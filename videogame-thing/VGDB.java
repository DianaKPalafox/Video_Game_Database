// STEP: Import required packages
import java.sql.*;
import java.util.*;
import java.io.FileWriter;
import java.io.FileReader;
import java.io.BufferedReader;
import java.io.PrintWriter;
import java.io.File;

public class VGDB {
    private Connection c = null;
    private String dbName;
    private boolean isConnected = false;
    
    private void openConnection(String _dbName) {
        dbName = _dbName;
        
        if (false == isConnected) {
            System.out.println("++++++++++++++++++++++++++++++++++");
            System.out.println("Open database: " + _dbName);
            
            try {
                String connStr = new String("jdbc:sqlite:");
                connStr = connStr + _dbName;
                
                // STEP: Register JDBC driver
                Class.forName("org.sqlite.JDBC");
                
                // STEP: Open a connection
                c = DriverManager.getConnection(connStr);
                
                // STEP: Diable auto transactions
                c.setAutoCommit(false);
                
                isConnected = true;
                System.out.println("success");
            } catch (Exception e) {
                System.err.println(e.getClass().getName() + ": " + e.getMessage());
                System.exit(0);
            }
            
            System.out.println("++++++++++++++++++++++++++++++++++");
        }
    }
    
    private void closeConnection() {
        if (true == isConnected) {
            System.out.println("++++++++++++++++++++++++++++++++++");
            System.out.println("Close database: " + dbName);
            
            try {
                // STEP: Close connection
                c.close();
                
                isConnected = false;
                dbName = "";
                System.out.println("success");
            } catch (Exception e) {
                System.err.println(e.getClass().getName() + ": " + e.getMessage());
                System.exit(0);
            }
            
            System.out.println("++++++++++++++++++++++++++++++++++");
        }
    }
    
    private void exampleUpdate() {
        System.out.println("++++++++++++++++++++++++++++++++++");
        System.out.println("Drop table");
        
        try{
            Statement s = c.createStatement();
            s.setQueryTimeout(30);
            s.executeUpdate("DROP TABLE IF EXISTS warehouse");
        }
        catch(SQLException e){
            System.err.println(e.getMessage());
        }
        
        System.out.println("++++++++++++++++++++++++++++++++++");
    }
    
    private void exampleQuery() {
        System.out.println("++++++++++++++++++++++++++++++++++");
        System.out.println("Q1");
        
        try {
            FileWriter writer = new FileWriter("output/1.out", false);
            PrintWriter printer = new PrintWriter(writer);
            
            printer.printf("%10s %-40s %10s %10s %10s\n", "wId", "wName", "wCap", "sId", "nId");
            
            Statement s = c.createStatement();
            s.setQueryTimeout(30);
            
            ResultSet rs = s.executeQuery("SELECT * FROM warehouse");
            
            Vector<Integer> eg = new Vector<Integer>();
            
            while(rs.next()){
                int id = rs.getInt("w_warehouse");
                String name = rs.getString("w_name");
                int cap = rs.getInt("w_capacity");
                int sid = rs.getInt("w_suppkey");
                int nid = rs.getInt("w_nationkey");
                
                printer.printf("%10s %-40s %10s %10s %10s\n", "" + id, name, "" + cap, "" + sid, "" + nid);
            }
            
            printer.close();
            writer.close();
        } catch (Exception e) {
            System.err.println(e.getClass().getName() + ": " + e.getMessage());
        }
        
        System.out.println("++++++++++++++++++++++++++++++++++");
    }
    
    private void resetDatabase()
    {
        try{
            Statement s = c.createStatement();
            s.setQueryTimeout(30);
            
            s.executeUpdate("DROP TABLE IF EXISTS customer");
            s.executeUpdate("DROP TABLE IF EXISTS storefront");
            s.executeUpdate("DROP TABLE IF EXISTS games");
            s.executeUpdate("DROP TABLE IF EXISTS items");
            s.executeUpdate("DROP TABLE IF EXISTS orders");
            s.executeUpdate("DROP TABLE IF EXISTS prefers");
            s.executeUpdate("DROP TABLE IF EXISTS sells");
            s.executeUpdate("DROP TABLE IF EXISTS contains");
            s.executeUpdate("DROP TABLE IF EXISTS accessories");
            
            s.executeUpdate("CREATE TABLE games(g_gameid decimal(10,0) not null, g_name char(25) not null, g_solo char(1) not null, g_genre char(25) not null, g_rating char(4) not null, g_year decimal(4,0) not null)");
            s.executeUpdate("CREATE TABLE accessories(a_accid decimal(10,0) not null, a_name char(25) not null, a_type char(25) not null, a_color char(25) not null)");
            s.executeUpdate("CREATE TABLE customer(c_custid decimal(10,0) not null, c_name varchar(40) not null, c_addy varchar(100) not null, c_phone char(15) not null);");
            s.executeUpdate("CREATE TABLE storefront(s_storeid decimal(10,0) not null, s_name char(25) not null, s_addy varchar(50) not null, s_phone char(14) not null);");
            s.executeUpdate("CREATE TABLE orders(o_orderid decimal(12,0) not null, o_custid decimal(10,0) not null, o_storeid decimal(10,0) not null, o_orderdate date not null, o_orderstatus char(1) not null);");
            s.executeUpdate("CREATE TABLE items(i_itemid decimal(10,0) not null, i_genericid decimal(10,0) not null, i_name varchar(25) not null, i_platform varchar(25) not null, i_type char(1) not null);");
            s.executeUpdate("CREATE TABLE sells(se_storeid decimal(10,0) not null, se_stockid decimal(10,0) not null, se_itemid decimal(10,0) not null, se_quantity decimal(5,0) not null, se_preowned char(1) not null);");
            s.executeUpdate("CREATE TABLE contains(co_orderid decimal(12,0) not null, co_storeid decimal(10,0) not null, co_stockid decimal(10,0) not null, co_quantity decimal(5,0) not null);");
            s.executeUpdate("CREATE TABLE prefers(p_custid decimal(10,0) not null, p_genre char(25) not null);");
            
            readCSV();
            
            System.out.println("Complete");
        }
        catch(SQLException e){
            System.err.println(e.getMessage());
        }
    }
    
    private void readCSV()
    {
        importCustomer();
        importGames();
        //add other imports
    }
    
    private void importCustomer()
    {
        try{
            Statement s = c.createStatement();
            s.setQueryTimeout(30);
            
            BufferedReader line = new BufferedReader(new FileReader("data/customer.csv"));
            String linetext = null;
            
            String sql = "INSERT INTO customer(c_custid, c_name, c_addy, c_phone) VALUES(?,?,?,?)";
            PreparedStatement ps = c.prepareStatement(sql);
            while ((linetext = line.readLine()) != null)
            {
                String[] data = linetext.split("|");
                int id = Integer.parseInt(data[0]);
                String name = data[1];
                String addy = data[2];
                String phone = data[3];
                
                ps.setInt(1, id);
                ps.setString(2, name);
                ps.setString(3, addy);
                ps.setString(4, phone);
                ps.executeUpdate();
            }
            ps.close();
            
        }
        catch(Exception e){
            System.err.println("Customer oops");
        }
    }
    
    private void importGames()
    {
        try{
            Statement s = c.createStatement();
            s.setQueryTimeout(30);
            
            BufferedReader line = new BufferedReader(new FileReader("data/games.csv"));
            String linetext = null;
            
            String sql = "INSERT INTO games(g_gameid, g_name, g_solo, g_genre, g_rating, g_year) VALUES(?,?,?,?,?,?)";
            PreparedStatement ps = c.prepareStatement(sql);
            while ((linetext = line.readLine()) != null)
            {
                String[] data = linetext.split("|");
                int id = Integer.parseInt(data[0]);
                String name = data[1];
                String solo = data[2];
                String genre = data[3];
                String rating = data[4];
                int year = Integer.parseInt(data[5]);
                
                ps.setInt(1, id);
                ps.setString(2, name);
                ps.setString(3, solo);
                ps.setString(4, genre);
                ps.setString(5, rating);
                ps.setInt(6, year);
                ps.executeUpdate();
            }
            ps.close();
        }
        catch(Exception e){
            System.err.println("Games oops");
        }
    }
    
    private void commenceSearch()
    {
        try {
            Statement s = c.createStatement();
            s.setQueryTimeout(30);
            String sql1 = "SELECT * FROM items WHERE i_name LIKE '";
            String sql2 = "' OR i_platform LIKE '";
            
            String input = "";
            
            /*
             while not string not inputted
             */
            
            //full appended search query
            String sql = sql1 + input + sql2 + input + "'";
            
            ResultSet rs = s.executeQuery("SELECT * FROM warehouse");
            
            Vector<Integer> eg = new Vector<Integer>();
            //something like "title, store, price" or something
            //System.out.println("%10s %-40s %10s %10s %10s\n", "wId", "wName", "wCap", "sId", "nId");
            
            while(rs.next()){
                int id = rs.getInt("w_warehouse");
                String name = rs.getString("w_name");
                int cap = rs.getInt("w_capacity");
                int sid = rs.getInt("w_suppkey");
                int nid = rs.getInt("w_nationkey");
                
                //printer.printf("%10s %-40s %10s %10s %10s\n", "" + id, name, "" + cap, "" + sid, "" + nid);
            }
        } catch (Exception e) {
            System.err.println(e.getClass().getName() + ": " + e.getMessage());
        }
    }
    
    /*
     global int userState (if 0 not logged in, if 1 its customer, if 2 its shop)
     */
    public static void main(String args[]) {
        VGDB sj = new VGDB();
        
        sj.openConnection("data/games.sqlite");
        //it runs but it doesn't do anything lol
        
        sj.resetDatabase();
        
        //sj.createTable();
        //sj.Q1();
        
        //main while loop in here
        
        /*
         Hi please use this hting
         
         while
         
         1. Log-In (if they're already logged in, then it's like idk Account Details)
         2. Search for Items
         3. Close App/Log ogg
         4. Current Listings (if shop)
         
         1.Log
         Register or Log-In
         Register as customer or shop?
         
         registerNewUser(bool customer){
         userState = customer
         
         out int hese things
         
         name, address, e-mail, phone (save in vars)
         sql = "INSERT INTO customer values ('" + name + "','" + address + "',' ... ")";
         s.executeUpdte(sql);
         
         4. select * items
         
         if 0
         1.L
         2.S
         3.C
         
         if 1
         1.A
         2.S
         3.C
         
         if 2
         1.A
         2.S
         3.Listings (view or add or delete)
         4.C
         
         2. input search
         
         sql1 = "SELECT * from items where i_name LIKE '";
         sql2 = "'";
         
         sql = sql1 + inputString + sql2;
         
         Sleect item or search again
         
         
         */
        
        sj.closeConnection();
    }
}
