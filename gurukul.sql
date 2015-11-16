-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 16, 2015 at 07:44 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `gurukul`
--

-- --------------------------------------------------------

--
-- Table structure for table `it_authassignment`
--

CREATE TABLE IF NOT EXISTS `it_authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `it_authassignment`
--

INSERT INTO `it_authassignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('admin', '1', NULL, NULL),
('member', '2', NULL, NULL),
('member', '3', NULL, 'N;'),
('member', '4', NULL, 'N;'),
('member', '5', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `it_authitem`
--

CREATE TABLE IF NOT EXISTS `it_authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL COMMENT '1 for action 2 for role',
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `it_authitem`
--

INSERT INTO `it_authitem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('admin', 2, NULL, NULL, NULL),
('AdminButtonsCreate', 1, NULL, NULL, NULL),
('AdminButtonsDelete', 1, NULL, NULL, NULL),
('AdminButtonsIndex', 1, NULL, NULL, NULL),
('AdminButtonsUpdate', 1, NULL, NULL, NULL),
('AdminCategoriesCreate', 1, '', '', 's:0:"";'),
('AdminCategoriesDelete', 1, '', '', 's:0:"";'),
('AdminCategoriesIndex', 1, '', '', 's:0:"";'),
('AdminCategoriesUpdate', 1, '', '', 's:0:"";'),
('AdminCmspageAccessdenied', 1, '', '', 's:0:"";'),
('AdminCmspageEdit', 1, '', '', 's:0:"";'),
('AdminCmspageIndex', 1, '', '', 's:0:"";'),
('AdminEmailmanagerEdit', 1, '', '', 's:0:"";'),
('AdminEmailmanagerIndex', 1, '', '', 's:0:"";'),
('AdminExamsCreate', 1, NULL, NULL, NULL),
('AdminExamsDelete', 1, NULL, NULL, NULL),
('AdminExamsIndex', 1, NULL, NULL, NULL),
('AdminExamsUpdate', 1, NULL, NULL, NULL),
('AdminFabricsAddbuttons', 1, NULL, NULL, NULL),
('AdminFabricsCreate', 1, NULL, NULL, NULL),
('AdminFabricsDelete', 1, NULL, NULL, NULL),
('AdminFabricsImageexist', 1, NULL, NULL, NULL),
('AdminFabricsIndex', 1, NULL, NULL, NULL),
('AdminFabricsUpdate', 1, NULL, NULL, NULL),
('AdminFabricsUploadcustomizeimages', 1, NULL, NULL, NULL),
('AdminFabricsUploadimages', 1, NULL, NULL, NULL),
('AdminItemsCreate', 1, NULL, NULL, NULL),
('AdminItemsDelete', 1, NULL, NULL, NULL),
('AdminItemsIndex', 1, NULL, NULL, NULL),
('AdminItemsOrders', 1, NULL, NULL, NULL),
('AdminItemsUpdate', 1, NULL, NULL, NULL),
('AdminItemsUpdatestatus', 1, NULL, NULL, NULL),
('AdminItemsVieworders', 1, NULL, NULL, NULL),
('AdminProductsAddimages', 1, '', '', 's:0:"";'),
('AdminProductsAddsizes', 1, '', '', 's:0:"";'),
('AdminProductsCreate', 1, '', '', 's:0:"";'),
('AdminProductsDelete', 1, '', '', 's:0:"";'),
('AdminProductsIndex', 1, '', '', 's:0:"";'),
('AdminProductsUpdate', 1, '', '', 's:0:"";'),
('AdminProductsUpload', 1, '', '', 's:0:"";'),
('AdminProductsView', 1, '', '', 's:0:"";'),
('AdminQuestionsCreate', 1, NULL, NULL, NULL),
('AdminQuestionsDelete', 1, NULL, NULL, NULL),
('AdminQuestionsDeleteoption', 1, NULL, NULL, NULL),
('AdminQuestionsIndex', 1, NULL, NULL, NULL),
('AdminQuestionsUpdate', 1, NULL, NULL, NULL),
('AdminSeoPagesCreate', 1, NULL, NULL, NULL),
('AdminSeoPagesDelete', 1, NULL, NULL, NULL),
('AdminSeoPagesIndex', 1, NULL, NULL, NULL),
('AdminSeoPagesUpdate', 1, NULL, NULL, NULL),
('AdminSubcategoriesCreate', 1, NULL, NULL, NULL),
('AdminSubcategoriesDelete', 1, NULL, NULL, NULL),
('AdminSubcategoriesIndex', 1, NULL, NULL, NULL),
('AdminSubcategoriesUpdate', 1, NULL, NULL, NULL),
('AdminUserAdd', 1, '', '', 's:0:"";'),
('AdminUserChangepassword', 1, '', '', 's:0:"";'),
('AdminUserEdit', 1, '', '', 's:0:"";'),
('AdminUserForgotpassword', 1, '', '', 's:0:"";'),
('AdminUserIndex', 1, '', '', 's:0:"";'),
('AdminUserLogin', 1, '', '', 's:0:"";'),
('AdminUserLogout', 1, '', '', 's:0:"";'),
('AdminUserProfile', 1, '', '', 's:0:"";'),
('AdminUserStatus', 1, '', '', 's:0:"";'),
('AdminUserUserlist', 1, '', '', 's:0:"";'),
('AdminUserViewaddress', 1, NULL, NULL, NULL),
('CartAddtocart', 1, NULL, NULL, NULL),
('CartCancel', 1, NULL, NULL, NULL),
('CartCheckout', 1, NULL, NULL, NULL),
('CartConfirm', 1, NULL, NULL, NULL),
('CartRemoveitem', 1, NULL, NULL, NULL),
('CartUpdateqty', 1, NULL, NULL, NULL),
('CartUpdateusermeasurement', 1, NULL, NULL, NULL),
('CartView', 1, NULL, NULL, NULL),
('FabricsIndex', 1, NULL, NULL, NULL),
('FabricsView', 1, NULL, NULL, NULL),
('guest', 2, NULL, NULL, NULL),
('member', 2, NULL, NULL, NULL),
('ProductsIndex', 1, NULL, NULL, NULL),
('ProductsView', 1, NULL, NULL, NULL),
('ProductsVieworders', 1, NULL, NULL, NULL),
('RightsDefaultIndex', 1, NULL, NULL, NULL),
('SiteIndex', 1, NULL, NULL, NULL),
('SiteLogin', 1, '', '', 's:0:"";'),
('SiteLogout', 1, '', '', 's:0:"";'),
('SiteSettimezone', 1, '', '', 's:0:"";'),
('UserChangepassword', 1, '', '', 's:0:"";'),
('UserDashboard', 1, '', '', 's:0:"";'),
('UserForgotpassword', 1, '', '', 's:0:"";'),
('UserMeasurementsCreate', 1, NULL, NULL, NULL),
('UserMeasurementsDelete', 1, NULL, NULL, NULL),
('UserMeasurementsSelectedmeasurements', 1, NULL, NULL, NULL),
('UserMeasurementsUpdate', 1, NULL, NULL, NULL),
('UserMeasurementsView', 1, NULL, NULL, NULL),
('UserProfile', 1, '', '', 's:0:"";'),
('UserResetpassword', 1, '', '', 's:0:"";'),
('UserSaveaddress', 1, NULL, NULL, NULL),
('UserSignup', 1, NULL, NULL, NULL),
('UserStates', 1, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `it_authitemchild`
--

CREATE TABLE IF NOT EXISTS `it_authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `it_authitemchild`
--

INSERT INTO `it_authitemchild` (`parent`, `child`) VALUES
('admin', 'AdminButtonsCreate'),
('admin', 'AdminButtonsDelete'),
('admin', 'AdminButtonsIndex'),
('admin', 'AdminButtonsUpdate'),
('admin', 'AdminCategoriesCreate'),
('admin', 'AdminCategoriesDelete'),
('admin', 'AdminCategoriesIndex'),
('admin', 'AdminCategoriesUpdate'),
('guest', 'AdminCmspageAccessdenied'),
('admin', 'AdminCmspageEdit'),
('admin', 'AdminCmspageIndex'),
('admin', 'AdminEmailmanagerEdit'),
('admin', 'AdminEmailmanagerIndex'),
('admin', 'AdminExamsCreate'),
('admin', 'AdminExamsDelete'),
('admin', 'AdminExamsIndex'),
('admin', 'AdminExamsUpdate'),
('admin', 'AdminFabricsAddbuttons'),
('admin', 'AdminFabricsCreate'),
('admin', 'AdminFabricsDelete'),
('admin', 'AdminFabricsImageexist'),
('admin', 'AdminFabricsIndex'),
('admin', 'AdminFabricsUpdate'),
('admin', 'AdminFabricsUploadcustomizeimages'),
('admin', 'AdminFabricsUploadimages'),
('admin', 'AdminItemsCreate'),
('admin', 'AdminItemsDelete'),
('admin', 'AdminItemsIndex'),
('admin', 'AdminItemsOrders'),
('admin', 'AdminItemsUpdate'),
('admin', 'AdminItemsUpdatestatus'),
('admin', 'AdminItemsVieworders'),
('admin', 'AdminProductsAddimages'),
('admin', 'AdminProductsAddsizes'),
('admin', 'AdminProductsCreate'),
('admin', 'AdminProductsDelete'),
('admin', 'AdminProductsIndex'),
('admin', 'AdminProductsUpdate'),
('admin', 'AdminProductsUpload'),
('admin', 'AdminProductsView'),
('admin', 'AdminQuestionsCreate'),
('admin', 'AdminQuestionsDelete'),
('admin', 'AdminQuestionsDeleteoption'),
('admin', 'AdminQuestionsIndex'),
('admin', 'AdminQuestionsUpdate'),
('admin', 'AdminSeoPagesCreate'),
('admin', 'AdminSeoPagesDelete'),
('admin', 'AdminSeoPagesIndex'),
('admin', 'AdminSeoPagesUpdate'),
('admin', 'AdminSubcategoriesCreate'),
('admin', 'AdminSubcategoriesDelete'),
('admin', 'AdminSubcategoriesIndex'),
('admin', 'AdminSubcategoriesUpdate'),
('admin', 'AdminUserAdd'),
('admin', 'AdminUserChangepassword'),
('admin', 'AdminUserEdit'),
('guest', 'AdminUserForgotpassword'),
('admin', 'AdminUserIndex'),
('guest', 'AdminUserLogin'),
('admin', 'AdminUserLogout'),
('admin', 'AdminUserProfile'),
('admin', 'AdminUserStatus'),
('admin', 'AdminUserUserlist'),
('admin', 'AdminUserViewaddress'),
('guest', 'CartAddtocart'),
('member', 'CartCancel'),
('member', 'CartCheckout'),
('member', 'CartConfirm'),
('guest', 'CartRemoveitem'),
('guest', 'CartUpdateqty'),
('member', 'CartUpdateusermeasurement'),
('guest', 'CartView'),
('guest', 'FabricsIndex'),
('guest', 'FabricsView'),
('guest', 'ProductsIndex'),
('guest', 'ProductsView'),
('member', 'ProductsVieworders'),
('guest', 'RightsDefaultIndex'),
('guest', 'SiteIndex'),
('guest', 'SiteLogin'),
('member', 'SiteLogout'),
('guest', 'SiteSettimezone'),
('member', 'UserChangepassword'),
('member', 'UserDashboard'),
('guest', 'UserForgotpassword'),
('member', 'UserMeasurementsCreate'),
('member', 'UserMeasurementsDelete'),
('member', 'UserMeasurementsSelectedmeasurements'),
('member', 'UserMeasurementsUpdate'),
('member', 'UserMeasurementsView'),
('member', 'UserProfile'),
('guest', 'UserResetpassword'),
('member', 'UserSaveaddress'),
('guest', 'UserSignup'),
('guest', 'UserStates');

-- --------------------------------------------------------

--
-- Table structure for table `it_categories`
--

CREATE TABLE IF NOT EXISTS `it_categories` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_description` text,
  `cat_meta_title` text,
  `cat_meta_keyword` text,
  `cat_meta_description` text,
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `it_categories`
--

INSERT INTO `it_categories` (`cat_id`, `cat_name`, `cat_description`, `cat_meta_title`, `cat_meta_keyword`, `cat_meta_description`) VALUES
(10, 'Java in 5 Days', 'It''s crash course.', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `it_cmspage`
--

CREATE TABLE IF NOT EXISTS `it_cmspage` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_pagename` varchar(100) NOT NULL,
  `c_title` varchar(250) NOT NULL,
  `c_subtitle` varchar(250) NOT NULL,
  `c_content` text NOT NULL,
  `c_app_content` text NOT NULL,
  `c_meta_title` varchar(250) NOT NULL,
  `c_meta_keyword` text NOT NULL,
  `c_meta_description` text NOT NULL,
  `c_status` tinyint(3) NOT NULL DEFAULT '1' COMMENT '0=inactive, 1=active',
  `c_created` datetime NOT NULL,
  `c_modified` datetime NOT NULL,
  PRIMARY KEY (`c_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `it_cmspage`
--

INSERT INTO `it_cmspage` (`c_id`, `c_pagename`, `c_title`, `c_subtitle`, `c_content`, `c_app_content`, `c_meta_title`, `c_meta_keyword`, `c_meta_description`, `c_status`, `c_created`, `c_modified`) VALUES
(1, 'About', 'About Us2 ', 'About Us', '<p><strong>About </strong></p> <p><strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <strong>1960s</strong> with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of <em>Lorem Ipsum</em>.<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <strong>1960s</strong> with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of <em>Lorem Ipsum</em>.<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <strong>1960s</strong> with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of <em>Lorem Ipsum</em>.<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <strong>1960s</strong> with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of <em>Lorem Ipsum</em>.<strong>Lorem Ipsum</strong> is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the <strong>1960s</strong> with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of <em>Lorem Ipsum</em>. Ãƒâ€šÃ‚Â </p> ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'about us', 'about', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2014-09-26 09:41:51', '2014-12-22 12:27:18'),
(2, 'Privacy Policy', 'Privacy Policy', 'Privacy Policy', '<p>Praesent tempor fringilla purus</p> <p>Donec ut odio ultricies, consequat sem eu, commodo eros. Praesent tempor fringilla purus, vitae laoreet tellus viverra eget. Aliquam sem elit, placerat eu tortor nec, pretium fermentum sapien. Morbi lobortis aliquam nisl ac hendrerit. Vestibulum hendrerit orci et iaculis eleifend. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam laoreet mauris a turpis varius iaculis. Praesent tincidunt, elit finibus pharetra tristique, odio arcu tristique erat, ultrices lobortis mauris sapien ac nulla.</p> <p>Morbi lobortis aliquam nisl ac hendrerit</p> <p>Donec ut odio ultricies, consequat sem eu, commodo eros. Praesent tempor fringilla purus, vitae laoreet tellus viverra eget. Aliquam sem elit, placerat eu tortor nec, pretium fermentum sapien. Morbi lobortis aliquam nisl ac hendrerit. Vestibulum hendrerit orci et iaculis eleifend. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p> ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'Privacy policy', 'Privacy policy', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2014-09-24 02:41:51', '2014-12-22 12:27:22'),
(3, 'Terms and Conditions', 'Terms and Conditions', 'Terms and Conditions', '<p>Praesent tempor fringilla purus</p> <p>Donec ut odio ultricies, consequat sem eu, commodo eros. Praesent tempor fringilla purus, vitae laoreet tellus viverra eget. Aliquam sem elit, placerat eu tortor nec, pretium fermentum sapien. Morbi lobortis aliquam nisl ac hendrerit. Vestibulum hendrerit orci et iaculis eleifend. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nam laoreet mauris a turpis varius iaculis. Praesent tincidunt, elit finibus pharetra tristique, odio arcu tristique erat, ultrices lobortis mauris sapien ac nulla.</p> <p>Morbi lobortis aliquam nisl ac hendrerit</p> <p>Donec ut odio ultricies, consequat sem eu, commodo eros. Praesent tempor fringilla purus, vitae laoreet tellus viverra eget. Aliquam sem elit, placerat eu tortor nec, pretium fermentum sapien. Morbi lobortis aliquam nisl ac hendrerit. Vestibulum hendrerit orci et iaculis eleifend. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p> ', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 'terms', 'terms', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry''s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.', 1, '2014-09-24 02:41:51', '2014-12-22 12:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `it_email_manager`
--

CREATE TABLE IF NOT EXISTS `it_email_manager` (
  `em_id` int(11) NOT NULL AUTO_INCREMENT,
  `em_title` varchar(100) DEFAULT NULL,
  `em_email_subject` varchar(100) DEFAULT NULL,
  `em_email_template` text,
  `em_created` datetime DEFAULT NULL,
  `em_modified` datetime DEFAULT NULL,
  PRIMARY KEY (`em_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `it_email_manager`
--

INSERT INTO `it_email_manager` (`em_id`, `em_title`, `em_email_subject`, `em_email_template`, `em_created`, `em_modified`) VALUES
(1, 'User Verification Mail', 'Welcome to {site_name}!', 'Hi {username}, <br /><br />Below is your verification link to verify your account.<br /><br />{verification_link}<br /><br />', '2014-09-25 16:30:00', '2014-12-22 12:26:54'),
(2, 'Forgot Password', 'Recover your password!', 'Hi {username},<br /><br />Below is the link to reset your password. <br /><br />{reset_link}<br /><br />Note : If you did not request to reset your password, then just ignore this email.<br />', '2014-09-25 16:30:00', '2014-12-22 12:27:03');

-- --------------------------------------------------------

--
-- Table structure for table `it_exams`
--

CREATE TABLE IF NOT EXISTS `it_exams` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_category_id` int(11) NOT NULL,
  `ex_title` varchar(200) NOT NULL,
  `ex_details` text,
  `ex_start_date_time` datetime NOT NULL,
  `ex_end_date_time` datetime NOT NULL,
  `ex_created` datetime NOT NULL,
  `ex_modified` datetime NOT NULL,
  PRIMARY KEY (`ex_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `it_exams`
--

INSERT INTO `it_exams` (`ex_id`, `ex_category_id`, `ex_title`, `ex_details`, `ex_start_date_time`, `ex_end_date_time`, `ex_created`, `ex_modified`) VALUES
(1, 10, 'JavaExams', 'JavaExams', '2015-09-30 16:00:00', '2015-09-30 01:00:00', '2015-09-30 07:14:15', '2015-09-30 07:42:54'),
(2, 10, 'java exam 2', 'java exam 2', '2015-09-29 01:00:00', '2015-09-30 01:30:00', '2015-09-30 07:39:40', '2015-09-30 07:39:40');

-- --------------------------------------------------------

--
-- Table structure for table `it_questions`
--

CREATE TABLE IF NOT EXISTS `it_questions` (
  `qt_id` int(11) NOT NULL AUTO_INCREMENT,
  `qt_exam_id` int(11) NOT NULL,
  `qt_name` varchar(255) NOT NULL,
  `qt_description` text,
  `qt_type` int(2) NOT NULL,
  `qt_marks` int(11) NOT NULL,
  `qt_created` datetime NOT NULL,
  `qt_modified` datetime NOT NULL,
  PRIMARY KEY (`qt_id`),
  UNIQUE KEY `qt_id` (`qt_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `it_questions`
--

INSERT INTO `it_questions` (`qt_id`, `qt_exam_id`, `qt_name`, `qt_description`, `qt_type`, `qt_marks`, `qt_created`, `qt_modified`) VALUES
(1, 1, 'What is the capital of india?', '', 1, 10, '2015-11-15 06:56:02', '2015-11-15 06:56:02'),
(2, 2, 'What is correct map of india?', 'Please select correct image also.', 2, 10, '2015-11-15 06:59:28', '2015-11-15 06:59:28');

-- --------------------------------------------------------

--
-- Table structure for table `it_questions_options`
--

CREATE TABLE IF NOT EXISTS `it_questions_options` (
  `qto_id` int(11) NOT NULL AUTO_INCREMENT,
  `qto_name` varchar(200) NOT NULL,
  `qto_image` varchar(255) DEFAULT NULL,
  `qto_question_id` int(11) NOT NULL,
  PRIMARY KEY (`qto_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;

--
-- Dumping data for table `it_questions_options`
--

INSERT INTO `it_questions_options` (`qto_id`, `qto_name`, `qto_image`, `qto_question_id`) VALUES
(1, 'India', NULL, 1),
(2, 'Delhi', NULL, 1),
(3, 'Jodhpur', NULL, 1),
(5, 'A', '5647dff89350e.png', 2),
(7, 'C', '5647dff8938b8.png', 2);

-- --------------------------------------------------------

--
-- Table structure for table `it_site_settings`
--

CREATE TABLE IF NOT EXISTS `it_site_settings` (
  `sst_id` int(11) NOT NULL AUTO_INCREMENT,
  `sst_name` varchar(255) NOT NULL,
  `sst_value` varchar(255) NOT NULL,
  PRIMARY KEY (`sst_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `it_user`
--

CREATE TABLE IF NOT EXISTS `it_user` (
  `u_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_first_name` varchar(200) NOT NULL,
  `u_last_name` varchar(200) NOT NULL,
  `u_email` varchar(200) DEFAULT NULL,
  `u_password` varchar(200) NOT NULL,
  `u_role` enum('admin','member') NOT NULL DEFAULT 'member',
  `u_gender` tinyint(3) DEFAULT '0' COMMENT '1=male, 2=Female',
  `u_status` tinyint(3) DEFAULT '0' COMMENT '0=inactive, 1=active, 2=deactive',
  `u_mail_verify` tinyint(3) DEFAULT '0' COMMENT '0=inactivtion, 1=activtion',
  `u_verkey` varchar(250) DEFAULT NULL COMMENT 'Account verification Key',
  `u_scrkey` varchar(250) DEFAULT NULL COMMENT 'Forgot password link ',
  `u_last_login_date` datetime DEFAULT NULL,
  `u_created` datetime NOT NULL,
  `u_modified` datetime NOT NULL,
  PRIMARY KEY (`u_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `it_user`
--

INSERT INTO `it_user` (`u_id`, `u_first_name`, `u_last_name`, `u_email`, `u_password`, `u_role`, `u_gender`, `u_status`, `u_mail_verify`, `u_verkey`, `u_scrkey`, `u_last_login_date`, `u_created`, `u_modified`) VALUES
(1, 'It', 'Gurukul', 'admin@itgurukul.com', '$2a$13$mFlSnpEY4X7.gf3ff4UKdeeZhgIskbSYyIVPWaUn7x2icbsUs11Aa', 'admin', 1, 1, 1, NULL, '02c00693466cf0cc34bdc26042f19677', '2015-06-03 01:26:27', '2014-12-23 02:20:00', '2015-09-07 21:06:04'),
(5, 'testuser', 'One', 'testuserone@gmail.com', '$2a$13$VzURb1EeBFmX/9yd7yiGZ.iar3xBDl/a4tC8gT.QLHcceStU.PMjK', 'member', 1, 1, 1, NULL, NULL, '2015-09-02 08:44:00', '2015-06-04 02:51:57', '2015-09-02 08:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `it_user_address`
--

CREATE TABLE IF NOT EXISTS `it_user_address` (
  `uad_id` int(11) NOT NULL AUTO_INCREMENT,
  `uad_user_id` int(11) NOT NULL,
  `uad_add1` varchar(255) NOT NULL,
  `uad_add2` varchar(255) DEFAULT NULL,
  `uad_country_id` int(11) NOT NULL,
  `uad_state_id` int(11) NOT NULL,
  `uad_city` varchar(200) NOT NULL,
  `uad_zipcode` varchar(200) NOT NULL,
  `uad_mobile` varchar(200) NOT NULL,
  `uad_type` tinyint(2) NOT NULL COMMENT '1=Shipping Address, 2=Billing Address',
  `uad_created` datetime NOT NULL,
  `uad_modified` datetime NOT NULL,
  PRIMARY KEY (`uad_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `it_user_address`
--

INSERT INTO `it_user_address` (`uad_id`, `uad_user_id`, `uad_add1`, `uad_add2`, `uad_country_id`, `uad_state_id`, `uad_city`, `uad_zipcode`, `uad_mobile`, `uad_type`, `uad_created`, `uad_modified`) VALUES
(1, 5, 'add1 hhhh', 'add2 lll', 240, 18655, 'jodhpur', '342001', '123456789', 1, '2015-07-24 07:45:43', '2015-07-25 07:03:47'),
(2, 5, 'add1 hhhh', 'add2 lll', 240, 18655, 'jodhpur', '342001', '123456789', 2, '2015-07-24 07:45:43', '2015-07-25 07:03:47');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
