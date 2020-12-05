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
            String sql = "drop table customer drop table storefront drop table games drop table items";
            sql = ".mode \"csv\" .separator \"|\" .import data/customer.csv customer .import data/storefront.csv storefront .import data/games.csv games .import data/items.csv items .import data/orders.csv orders .import data/prefers.csv prefers .import data/sells.csv sells .import data/contains.csv contains .import data/accessories.csv accessories";
            s.executeUpdate("DROP TABLE IF EXISTS warehouse");
            s.executeUpdate(sql);
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
                
                printer.printf("%10s %-40s %10s %10s %10s\n", "" + id, name, "" + cap, "" + sid, "" + nid);
            }
            
            printer.close();
            writer.close();
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
