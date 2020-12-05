#!/bin/bash

#rm -f score.res
#rm -f output/*

javac VGDB.java
java -classpath ".:sqlite-jdbc-3.32.3.2.jar" VGDB
