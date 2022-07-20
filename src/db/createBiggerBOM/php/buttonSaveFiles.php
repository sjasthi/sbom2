
<?php
$date = date('m/d/Y h:i:s a', time());

$strPrepend = '
-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: '.$date.'
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sbom_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `apps_components`
--

DROP TABLE IF EXISTS `apps_components`;
CREATE TABLE IF NOT EXISTS `apps_components` (
    `line_id` int(10) NOT NULL,
    `red_app_id` varchar(10) NOT NULL,
    `red_app_id2` varchar(10) NOT NULL,
    `cmpt_id` varchar(10) NOT NULL,
    `cmpt_id2` varchar(10) NOT NULL,
    `cmpt_name` varchar(100) NOT NULL,
    `cmpt_version` varchar(50) NOT NULL,
    `app_id` varchar(100) NOT NULL,
    `app_id2` varchar(100) NOT NULL,
    `app_name` varchar(10) NOT NULL,
    `app_version` varchar(50) NOT NULL,
    `license` varchar(120) DEFAULT NULL,
    `status` varchar(10) DEFAULT NULL,
    `requester` varchar(50) DEFAULT NULL,
    `monitoring_id` varchar(10) DEFAULT NULL,
    `monitoring_digest` varchar(100) DEFAULT NULL,
    `issue_count` int(3) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `apps_components`
--

';

    // add button cases for bigger BOMs here..
    if( isset( $_POST['button'] ) ) {
        $button = $_POST['button'];

        switch( $button ) {
            case "100": {
                echo "Createed 100 new BOMS";
                
                $saveFile = fopen( "sql/small_100.sql", 'w' );
                $str = createSQL( factorOfTen( createTinyBOM() ) );

                $GLOBALS['db'] -> query( "DROP TABLE `apps_components`" );
                $GLOBALS['db'] -> query(
                    "CREATE TABLE `apps_components` (
                        `line_id` int(10) NOT NULL,
                        `red_app_id` varchar(10) NOT NULL,
                        `cmpt_id` varchar(10) NOT NULL,
                        `cmpt_name` varchar(100) NOT NULL,
                        `cmpt_version` varchar(50) NOT NULL,
                        `app_id` varchar(100) NOT NULL,
                        `app_name` varchar(10) NOT NULL,
                        `app_version` varchar(50) NOT NULL,
                        `license` varchar(120) DEFAULT NULL,
                        `status` varchar(10) DEFAULT NULL,
                        `requester` varchar(50) DEFAULT NULL,
                        `monitoring_id` varchar(10) DEFAULT NULL,
                        `monitoring_digest` varchar(100) DEFAULT NULL,
                        `issue_count` int(3) DEFAULT NULL
                    )"
                );
                
                $GLOBALS['db'] -> query( $str );

                $str = $strPrepend.$str;
                fwrite( $saveFile, $str );
            } break;

            case "1,000": {
                echo "Createed 1,000 new BOMS";
                
                $saveFile = fopen( "sql/medium_1000.sql", 'w' );
                $str =
                    createSQL(
                        addLayer( // add another layer (4 levels)
                            factorOfTen( // 1,000
                                factorOfTen( createTinyBOM() ) // 100 (default: 2 levels of depth)
                            ), 2
                        )
                    );

                $GLOBALS['db'] -> query( "DROP TABLE `apps_components`" );
                $GLOBALS['db'] -> query(
                    "CREATE TABLE `apps_components` (
                        `line_id` int(10) NOT NULL,
                        `red_app_id` varchar(10) NOT NULL,
                        `red_app_id2` varchar(10) NOT NULL,
                        `cmpt_id` varchar(10) NOT NULL,
                        `cmpt_id2` varchar(10) NOT NULL,
                        `cmpt_name` varchar(100) NOT NULL,
                        `cmpt_version` varchar(50) NOT NULL,
                        `app_id` varchar(100) NOT NULL,
                        `app_id2` varchar(100) NOT NULL,
                        `app_name` varchar(10) NOT NULL,
                        `app_version` varchar(50) NOT NULL,
                        `license` varchar(120) DEFAULT NULL,
                        `status` varchar(10) DEFAULT NULL,
                        `requester` varchar(50) DEFAULT NULL,
                        `monitoring_id` varchar(10) DEFAULT NULL,
                        `monitoring_digest` varchar(100) DEFAULT NULL,
                        `issue_count` int(3) DEFAULT NULL
                    )"
                );
                
                $GLOBALS['db'] -> query( $str );

                $str = $strPrepend.$str;
                fwrite( $saveFile, $str );
            } break;

            case "10,000": {
                echo "Createed 10,000 new BOMS";
                
                $saveFile = fopen( "sql/large_10000.sql", 'w' );
                $str =
                    createSQL(
                        addLayer( // add another layer (6 levels)
                            addLayer( // add another layer (4 levels)
                                factorOfTen( // 10,000
                                    factorOfTen( // 1,000
                                        factorOfTen( createTinyBOM() ) // 100 (default: 2 levels of depth)
                                    )
                                ), 2
                            ), 3
                        )
                    );

                $GLOBALS['db'] -> query( "DROP TABLE `apps_components`" );
                $GLOBALS['db'] -> query(
                    "CREATE TABLE `apps_components` (
                        `line_id` int(10) NOT NULL,
                        `red_app_id` varchar(10) NOT NULL,
                        `red_app_id2` varchar(10) NOT NULL,
                        `red_app_id3` varchar(10) NOT NULL,
                        `cmpt_id` varchar(10) NOT NULL,
                        `cmpt_id2` varchar(10) NOT NULL,
                        `cmpt_id3` varchar(10) NOT NULL,
                        `cmpt_name` varchar(100) NOT NULL,
                        `cmpt_version` varchar(50) NOT NULL,
                        `app_id` varchar(100) NOT NULL,
                        `app_id2` varchar(100) NOT NULL,
                        `app_id3` varchar(100) NOT NULL,
                        `app_name` varchar(10) NOT NULL,
                        `app_version` varchar(50) NOT NULL,
                        `license` varchar(120) DEFAULT NULL,
                        `status` varchar(10) DEFAULT NULL,
                        `requester` varchar(50) DEFAULT NULL,
                        `monitoring_id` varchar(10) DEFAULT NULL,
                        `monitoring_digest` varchar(100) DEFAULT NULL,
                        `issue_count` int(3) DEFAULT NULL
                    )"
                );
                
                $GLOBALS['db'] -> query( $str );

                $str = $strPrepend.$str;
                fwrite( $saveFile, $str );
            } break;
        }
    }
?>
