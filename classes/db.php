<?php

/* File Name : db.php
 *  Description : Database's Connection Functions 
 *  Author  : Sushil Singh  Date: 12th,Nov,2010 
*/     
//error_reporting(1);
class db {
    var $link;
    var $result;
    var $sql;

    /* Function Header :makeConnection()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To connect the database Connection.
    */

    function makeConnection() {
        //echo SERVER;
        $this->link = mysql_connect(SERVER,USER,PASSWORD);
        if ( ! $this->link )
            die( "Couldn't connect to MySQL. ".mysql_error());
        mysql_select_db( DATABASE, $this->link ) or die( "Couldn't open {DATABASE} database. ".mysql_error());

        return($this->link);
    }
    /* Function Header :closeConnection()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To close the database Connection.
    */
    function closeConnection() {
        mysql_close($this->link);
    }
    /* Function Header :query($query)
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To query in the database.
    */
    public function query($query) {
        $this->makeConnection();
        $res = mysql_query($query,$this->link) or die(mysql_error());
        if(!$res) {
            trigger_error('FAILED: '.$query, E_USER_NOTICE);
        }else {
            return $res ;
        }
    }
    /* Function Header :fetchRow($res)
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To Fetch data Connection.
    */
    function fetchRow($res) {
        return mysql_fetch_assoc($res);
    }

    /* Function Header :numRows($res)
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To calculate number of rows of  data Connection.
    */
    function numRows($res) {
        return mysql_num_rows($res);
    }

    /* Function Header :isEmpty($res)
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To check whether a variable is empty.
    */
    function isEmpty($res) {
        if($this->numRows($res) > 0) {
            return false;
        }else {
            return true;
        }
    }

    /* Function Header :insertId()
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To get the id generated in the last query.
    */
    function insertId() {
        return mysql_insert_id($this->link);
    }

    /* Function Header :process_submission( $table, $submission, $id=array())
*             Args: $emailId
*           Errors: none
*     Return Value: none
*      Description: To insert or update query in the database.
    */

    public function process_submission( $table, $submission, $id=array( ) ) {

        $this->makeConnection();
        $fieldArray = array( );
        $this->sql = "SELECT * FROM $table LIMIT 0";
        $this->result = $this->query($this->sql);
        //if(! $this->query( ) ) $this->error( );

        /**
         * Get the array of fields from the table, and free the result
         */
        //echo "no of field:".mysql_num_fields( $this->result );
        for( $i = 0; $i < mysql_num_fields( $this->result ); ++$i ) {
            $info = mysql_fetch_field( $this->result );
            $fieldArray[$info->name] = 1;
        }

        /**
         * Check the submission against this array of fields.  If a
         * field in submission is in the array of fields, they match up
         * Using keys here because it's faster.
         */
        foreach( $submission as $key=>$val ) {
            if( array_key_exists( $key, $fieldArray ) ) {
                //$val = $this->clean( $val );
                $fields[$key] = "'$val'";
            }
        }

        if (! count( $fields ) ) {
            /** none of the fields match, so we can bail out **/
            return( FALSE );
            //die( var_dump( $fieldArray )."<hr />None of the submission fields match the table fields for table $table on database $db.  The table fields are listed above" );
        }
        //echo "INSERT COMMM";
        if ( empty( $id ) ) {
            $this->sql = "INSERT INTO $table (" . implode(',', array_keys( $fields ) ). ") VALUES (". implode(',',array_values( $fields ) ). ")";

            $this->result = $this->query($this->sql);
            if( mysql_affected_rows() > 0 ) {
                return( mysql_insert_id() );
            } else {
                return( 0 );
            }
        } else {
            $db_id = array_keys( $id );
            $db_val = array_values( $id );

            foreach ($fields as $key=>$val) {
                $update[] = "$key = $val";
            }

            $this->sql = "UPDATE $table SET " . implode( ',', $update ) . " where $db_id[0] = $db_val[0]";
            //echo $this->sql; die();
            $this->result = $this->query($this->sql);
            return( $db_val[0] );
        }
        return( false );
    }

}
?>