USE [master]
GO
/****** Object:  Database [dbhr3_test]    Script Date: 25/01/2020 12:56:38 PM ******/
CREATE DATABASE [dbhr3_test]
 CONTAINMENT = NONE
 ON  PRIMARY 
( NAME = N'dbhr3_test', FILENAME = N'C:\Databases\dbhr3_test.mdf' , SIZE = 18496KB , MAXSIZE = UNLIMITED, FILEGROWTH = 1024KB )
 LOG ON 
( NAME = N'dbhr3_test_log', FILENAME = N'C:\Databases\dbhr3_test_log.ldf' , SIZE = 16832KB , MAXSIZE = 2048GB , FILEGROWTH = 10%)
GO
ALTER DATABASE [dbhr3_test] SET COMPATIBILITY_LEVEL = 110
GO
IF (1 = FULLTEXTSERVICEPROPERTY('IsFullTextInstalled'))
begin
EXEC [dbhr3_test].[dbo].[sp_fulltext_database] @action = 'enable'
end
GO
ALTER DATABASE [dbhr3_test] SET ANSI_NULL_DEFAULT OFF 
GO
ALTER DATABASE [dbhr3_test] SET ANSI_NULLS OFF 
GO
ALTER DATABASE [dbhr3_test] SET ANSI_PADDING OFF 
GO
ALTER DATABASE [dbhr3_test] SET ANSI_WARNINGS OFF 
GO
ALTER DATABASE [dbhr3_test] SET ARITHABORT OFF 
GO
ALTER DATABASE [dbhr3_test] SET AUTO_CLOSE OFF 
GO
ALTER DATABASE [dbhr3_test] SET AUTO_SHRINK OFF 
GO
ALTER DATABASE [dbhr3_test] SET AUTO_UPDATE_STATISTICS ON 
GO
ALTER DATABASE [dbhr3_test] SET CURSOR_CLOSE_ON_COMMIT OFF 
GO
ALTER DATABASE [dbhr3_test] SET CURSOR_DEFAULT  GLOBAL 
GO
ALTER DATABASE [dbhr3_test] SET CONCAT_NULL_YIELDS_NULL OFF 
GO
ALTER DATABASE [dbhr3_test] SET NUMERIC_ROUNDABORT OFF 
GO
ALTER DATABASE [dbhr3_test] SET QUOTED_IDENTIFIER OFF 
GO
ALTER DATABASE [dbhr3_test] SET RECURSIVE_TRIGGERS OFF 
GO
ALTER DATABASE [dbhr3_test] SET  ENABLE_BROKER 
GO
ALTER DATABASE [dbhr3_test] SET AUTO_UPDATE_STATISTICS_ASYNC OFF 
GO
ALTER DATABASE [dbhr3_test] SET DATE_CORRELATION_OPTIMIZATION OFF 
GO
ALTER DATABASE [dbhr3_test] SET TRUSTWORTHY OFF 
GO
ALTER DATABASE [dbhr3_test] SET ALLOW_SNAPSHOT_ISOLATION OFF 
GO
ALTER DATABASE [dbhr3_test] SET PARAMETERIZATION SIMPLE 
GO
ALTER DATABASE [dbhr3_test] SET READ_COMMITTED_SNAPSHOT OFF 
GO
ALTER DATABASE [dbhr3_test] SET HONOR_BROKER_PRIORITY OFF 
GO
ALTER DATABASE [dbhr3_test] SET RECOVERY FULL 
GO
ALTER DATABASE [dbhr3_test] SET  MULTI_USER 
GO
ALTER DATABASE [dbhr3_test] SET PAGE_VERIFY CHECKSUM  
GO
ALTER DATABASE [dbhr3_test] SET DB_CHAINING OFF 
GO
ALTER DATABASE [dbhr3_test] SET FILESTREAM( NON_TRANSACTED_ACCESS = OFF ) 
GO
ALTER DATABASE [dbhr3_test] SET TARGET_RECOVERY_TIME = 0 SECONDS 
GO
EXEC sys.sp_db_vardecimal_storage_format N'dbhr3_test', N'ON'
GO
USE [dbhr3_test]
GO
/****** Object:  Schema [dbhr3_test]    Script Date: 25/01/2020 12:56:38 PM ******/
CREATE SCHEMA [dbhr3_test]
GO
/****** Object:  Schema [m2ss]    Script Date: 25/01/2020 12:56:38 PM ******/
CREATE SCHEMA [m2ss]
GO
/****** Object:  Table [dbo].[access_menu_left_main]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[access_menu_left_main](
	[id] [int] IDENTITY(20,1) NOT NULL,
	[menu_name] [nvarchar](200) NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
	[appearance] [int] NULL,
 CONSTRAINT [PK_access_menu_left_main_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [access_menu_left_main$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[access_menu_left_mainTest]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[access_menu_left_mainTest](
	[id] [int] IDENTITY(20,1) NOT NULL,
	[menu_name] [nvarchar](200) NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[access_menu_left_sub]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[access_menu_left_sub](
	[id] [int] IDENTITY(93,1) NOT NULL,
	[menu_left_id] [int] NOT NULL,
	[menu_name_sub] [nvarchar](200) NULL,
	[page_name] [nvarchar](200) NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_access_menu_left_sub_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [access_menu_left_sub$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[access_menu_matrix]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[access_menu_matrix](
	[id] [int] IDENTITY(128,1) NOT NULL,
	[user_type_id] [int] NOT NULL,
	[menu_left_main_id] [int] NOT NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_access_menu_matrix_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [access_menu_matrix$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[access_menu_matrix_sub]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[access_menu_matrix_sub](
	[id] [int] IDENTITY(617,1) NOT NULL,
	[user_type_id] [int] NOT NULL,
	[access_menu_left_sub_id] [int] NOT NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_access_menu_matrix_sub_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [access_menu_matrix_sub$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[approvalsequence_shortleave]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[approvalsequence_shortleave](
	[id] [int] IDENTITY(86,1) NOT NULL,
	[department_id] [int] NOT NULL,
	[position_id] [int] NOT NULL,
	[approverInSequence1] [int] NOT NULL,
	[approverInSequence2] [int] NOT NULL,
	[active] [int] NOT NULL,
	[chronological] [int] NOT NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_approvalsequence_shortleave_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[position_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [approvalsequence_shortleave$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[approvalsequence_shortleave_history]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[approvalsequence_shortleave_history](
	[id] [int] IDENTITY(74,1) NOT NULL,
	[position_id] [int] NOT NULL,
	[previous_approver] [int] NOT NULL,
	[new_approver] [int] NOT NULL,
	[active] [int] NOT NULL,
	[notes] [nvarchar](1000) NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_approvalsequence_shortleave_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[position_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [approvalsequence_shortleave_history$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[approvalsequence_standard_history]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[approvalsequence_standard_history](
	[id] [int] IDENTITY(162,1) NOT NULL,
	[position_id] [int] NOT NULL,
	[previous_approver] [int] NOT NULL,
	[new_approver] [int] NOT NULL,
	[sequence_no] [int] NOT NULL,
	[active] [int] NOT NULL,
	[notes] [nvarchar](1000) NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_approvalsequence_standard_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[position_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [approvalsequence_standard_history$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[approvalsequence_standardleave]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[approvalsequence_standardleave](
	[id] [int] IDENTITY(162,1) NOT NULL,
	[department_id] [int] NOT NULL,
	[position_id] [int] NOT NULL,
	[approver_id] [int] NOT NULL,
	[sequence_no] [int] NOT NULL,
	[is_final] [int] NOT NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](7) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_approvalsequence_standardleave_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [approvalsequence_standardleave$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[approvalsequence_standardleave_5]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[approvalsequence_standardleave_5](
	[id] [int] IDENTITY(162,1) NOT NULL,
	[department_id] [int] NOT NULL,
	[position_id] [int] NOT NULL,
	[approver_id] [int] NOT NULL,
	[sequence_no] [int] NOT NULL,
	[is_final] [int] NOT NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](7) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_approvalsequence_standardleave_5_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[certificate]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[certificate](
	[id] [int] IDENTITY(183,1) NOT NULL,
	[name] [nvarchar](250) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_certificate_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [certificate$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[clearance]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[clearance](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staffId] [nvarchar](20) NOT NULL,
	[isCleared] [tinyint] NOT NULL,
	[dateCreated] [datetime] NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[clearance_approval_status]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[clearance_approval_status](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clearance_id] [int] NOT NULL,
	[clearance_process_id] [int] NOT NULL,
	[staffId] [varchar](50) NOT NULL,
	[approverStaffId] [nchar](10) NOT NULL,
	[status] [varchar](50) NOT NULL,
	[sequence_no] [int] NOT NULL,
	[comment] [nvarchar](max) NOT NULL,
	[dateUpdated] [datetime] NOT NULL,
	[current_flag] [tinyint] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[clearance_approver]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[clearance_approver](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[position_id] [int] NOT NULL,
	[active] [smallint] NOT NULL,
	[sequence_no] [smallint] NOT NULL,
	[created_by] [nchar](10) NOT NULL,
	[created] [datetime2](0) NOT NULL,
	[modified] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_clearance_approver] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[clearance_history]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[clearance_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[clearance_id] [int] NOT NULL,
	[clearance_process_id] [int] NOT NULL,
	[staffId] [nvarchar](20) NOT NULL,
	[approverStaffId] [nchar](20) NOT NULL,
	[status] [nchar](20) NOT NULL,
	[comment] [nvarchar](max) NOT NULL,
	[dateUpdated] [datetime] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[clearance_process]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[clearance_process](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[contactdetails]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[contactdetails](
	[id] [int] IDENTITY(2050,1) NOT NULL,
	[staff_id] [int] NOT NULL,
	[contacttype_id] [int] NOT NULL,
	[stafffamily_id] [int] NOT NULL,
	[data] [nvarchar](1024) NULL,
	[isCurrent] [nvarchar](1) NULL,
	[isFamily] [nvarchar](1) NULL,
 CONSTRAINT [PK_contactdetails_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staff_id] ASC,
	[contacttype_id] ASC,
	[stafffamily_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [contactdetails$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[contacttype]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[contacttype](
	[id] [int] IDENTITY(6,1) NOT NULL,
	[name] [nvarchar](500) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_contacttype_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [contacttype$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[degree]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[degree](
	[id] [int] IDENTITY(15,1) NOT NULL,
	[name] [nvarchar](250) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_degree_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [degree$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[delegation]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[delegation](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[requestNo] [nvarchar](11) NOT NULL,
	[shl] [smallint] NULL,
	[stl] [smallint] NULL,
	[otl] [smallint] NULL,
	[clr] [smallint] NULL,
	[staffIdFrom] [nvarchar](11) NOT NULL,
	[staffIdTo] [nvarchar](11) NOT NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[status] [nvarchar](11) NOT NULL,
	[reason] [nvarchar](500) NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_delegation_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[requestNo] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [delegation$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[delegation_history]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[delegation_history](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[delegation_id] [int] NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staff_id] [int] NOT NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](500) NULL,
	[ipAddress] [nvarchar](16) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_delegation_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[delegation_id] ASC,
	[requestNo] ASC,
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [delegation_history$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[delegation_pages]    Script Date: 25/01/2020 12:56:38 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[delegation_pages](
	[id] [int] IDENTITY(5,1) NOT NULL,
	[display_name] [nvarchar](50) NOT NULL,
	[active] [smallint] NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_delegation_pages_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [delegation_pages$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[delegation_pages_access]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[delegation_pages_access](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[delegation_id] [smallint] NOT NULL,
	[delegation_pages_id] [smallint] NOT NULL,
	[access_menu_left_sub_id] [smallint] NOT NULL,
	[user_type] [smallint] NOT NULL,
	[active] [smallint] NOT NULL,
	[createdBy] [nvarchar](10) NOT NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_delegation_pages_access_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [delegation_pages_access$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[department]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[department](
	[id] [int] IDENTITY(19,1) NOT NULL,
	[name] [nvarchar](500) NULL,
	[shortName] [nvarchar](100) NULL,
	[isAcademic] [smallint] NULL,
	[managerId] [nvarchar](10) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_department_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [department$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[e_forms]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[e_forms](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[name] [nvarchar](200) NOT NULL,
	[active] [tinyint] NOT NULL,
	[created] [datetime2](7) NOT NULL,
	[modified] [datetime] NOT NULL,
 CONSTRAINT [PK_e_forms] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[e_forms_request]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[e_forms_request](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[requestNo] [nvarchar](50) NOT NULL,
	[requestBy] [int] NOT NULL,
	[eFormId] [smallint] NOT NULL,
	[status] [nvarchar](50) NOT NULL,
	[reason] [nvarchar](1024) NOT NULL,
	[updatedBy] [nvarchar](100) NULL,
	[createdBy] [nvarchar](50) NOT NULL,
	[created] [datetime2](0) NOT NULL,
	[modified] [datetime] NOT NULL,
 CONSTRAINT [PK_e_forms_request] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[emergencyleavebalancedetails]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[emergencyleavebalancedetails](
	[id] [int] IDENTITY(1196,1) NOT NULL,
	[emergencyleavebalance_id] [nvarchar](15) NOT NULL,
	[staffId] [nvarchar](11) NOT NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[total] [smallint] NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](1024) NULL,
	[addType] [smallint] NULL,
	[createdBy] [nvarchar](11) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_emergencyleavebalancedetails_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[emergencyleavebalance_id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [emergencyleavebalancedetails$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[emergencyleavereset]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[emergencyleavereset](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[requestNo] [nvarchar](15) NULL,
	[sponsorType] [nvarchar](8) NULL,
	[dateFiled] [datetime2](0) NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_emergencyleavereset_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [emergencyleavereset$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[employmentdetail]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[employmentdetail](
	[id] [int] IDENTITY(591,1) NOT NULL,
	[staff_id] [int] NOT NULL,
	[registrationCardNo] [nvarchar](10) NULL,
	[joinDate] [date] NULL,
	[isCurrent] [int] NULL,
	[status_id] [int] NOT NULL,
	[department_id] [int] NOT NULL,
	[section_id] [int] NOT NULL,
	[jobtitle_id] [int] NOT NULL,
	[sponsor_id] [int] NOT NULL,
	[salarygrade_id] [int] NOT NULL,
	[employmenttype_id] [int] NOT NULL,
	[specialization_id] [int] NOT NULL,
	[qualification_id] [int] NOT NULL,
	[position_id] [int] NOT NULL,
	[position_category_id] [int] NOT NULL,
	[modified] [datetime] NOT NULL,
 CONSTRAINT [PK_employmentdetail_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staff_id] ASC,
	[status_id] ASC,
	[department_id] ASC,
	[section_id] ASC,
	[jobtitle_id] ASC,
	[sponsor_id] ASC,
	[salarygrade_id] ASC,
	[employmenttype_id] ASC,
	[specialization_id] ASC,
	[qualification_id] ASC,
	[position_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [employmentdetail$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[exit_interview]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[exit_interview](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[staffId] [int] NOT NULL,
	[dateSubmitted] [datetime] NOT NULL,
	[aTick1] [tinyint] NULL,
	[aTick2] [tinyint] NULL,
	[aTick3] [tinyint] NULL,
	[aTick4] [tinyint] NULL,
	[aTick5] [tinyint] NULL,
	[aTick6] [tinyint] NULL,
	[aTick7] [tinyint] NULL,
	[aTick7Reason] [text] NULL,
	[theJobRdo1] [tinyint] NOT NULL,
	[theJobRdo2] [tinyint] NOT NULL,
	[theJobRdo3] [tinyint] NOT NULL,
	[theJobRdo4] [tinyint] NOT NULL,
	[theJobRdo5] [tinyint] NOT NULL,
	[theJobRdo6] [tinyint] NOT NULL,
	[theJobRdo7] [tinyint] NOT NULL,
	[theJobRdo8] [tinyint] NOT NULL,
	[theJobRdo9] [tinyint] NOT NULL,
	[theJobRdo10] [tinyint] NOT NULL,
	[theJobRdo11] [tinyint] NOT NULL,
	[theJobRdo12] [tinyint] NOT NULL,
	[theJobComment13] [text] NOT NULL,
	[theCollegeRdo1] [tinyint] NOT NULL,
	[theCollegeRdo2] [tinyint] NOT NULL,
	[theCollegeRdo3] [tinyint] NOT NULL,
	[theCollegeRdo4] [tinyint] NOT NULL,
	[theCollegeRdo5] [tinyint] NOT NULL,
	[theCollegeRdo6] [tinyint] NOT NULL,
	[theCollegeComment7] [text] NOT NULL,
	[theSupervisorRdo1] [tinyint] NOT NULL,
	[theSupervisorRdo2] [tinyint] NOT NULL,
	[theSupervisorRdo3] [tinyint] NOT NULL,
	[theSupervisorRdo4] [tinyint] NOT NULL,
	[theSupervisorRdo5] [tinyint] NOT NULL,
	[theSupervisorRdo6] [tinyint] NOT NULL,
	[theSupervisorComment7] [text] NOT NULL,
	[theManagementRdo1] [tinyint] NOT NULL,
	[theManagementRdo2] [tinyint] NOT NULL,
	[theManagementRdo3] [tinyint] NOT NULL,
	[theManagementRdo4] [tinyint] NOT NULL,
	[theManagementRdo5] [tinyint] NOT NULL,
	[theManagementRdo6] [tinyint] NOT NULL,
	[theManagementRdo7] [tinyint] NOT NULL,
	[theManagementComment8] [text] NOT NULL,
	[generalComment1] [text] NOT NULL,
	[generalComment2] [text] NOT NULL,
	[generalComment3] [text] NOT NULL
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[extracertificates]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[extracertificates](
	[id] [int] IDENTITY(21,1) NOT NULL,
	[name] [nvarchar](256) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_extracertificates_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [extracertificates$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[fpuserlog]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[fpuserlog](
	[recordDate] [date] NOT NULL,
	[userid] [nvarchar](50) NOT NULL,
	[inEvent] [nvarchar](50) NULL,
	[inTime] [datetime] NULL,
	[outEvent] [varchar](50) NULL,
	[outTime] [datetime] NULL,
	[synctime] [datetime] NULL,
 CONSTRAINT [PK_fpuserlog_recordDate] PRIMARY KEY CLUSTERED 
(
	[recordDate] ASC,
	[userid] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[holiday]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[holiday](
	[id] [int] IDENTITY(29,1) NOT NULL,
	[name] [nvarchar](500) NOT NULL,
	[arabicName] [nvarchar](500) NOT NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[total] [int] NULL,
	[isRamadan] [int] NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_holiday_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [holiday$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleavebalance]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleavebalance](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[requestNo] [nvarchar](15) NULL,
	[sponsorType] [smallint] NULL,
	[dateFiled] [datetime2](0) NULL,
	[notes] [nvarchar](500) NULL,
	[attachment] [nvarchar](500) NULL,
	[isFinalized] [nvarchar](1) NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleavebalance_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleavebalance$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleavebalancedetails]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleavebalancedetails](
	[id] [int] IDENTITY(1484,1) NOT NULL,
	[internalleavebalance_id] [nvarchar](15) NOT NULL,
	[leavetype_id] [int] NOT NULL,
	[staffId] [nvarchar](11) NOT NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[total] [smallint] NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](1024) NULL,
	[addType] [smallint] NULL,
	[createdBy] [nvarchar](11) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleavebalancedetails_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[internalleavebalance_id] ASC,
	[leavetype_id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleavebalancedetails$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleavebalancedetails_draft]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleavebalancedetails_draft](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[internalleavebalance_id] [nvarchar](15) NOT NULL,
	[leavetype_id] [int] NOT NULL,
	[staffId] [nvarchar](11) NOT NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[total] [smallint] NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](1024) NULL,
	[addType] [smallint] NULL,
	[createdBy] [nvarchar](11) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleavebalancedetails_draft_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[internalleavebalance_id] ASC,
	[leavetype_id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleavebalancedetails_draft$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleaveovertime]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleaveovertime](
	[id] [int] IDENTITY(10,1) NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staff_id] [nvarchar](11) NOT NULL,
	[currentStatus] [nvarchar](50) NOT NULL,
	[current_sequence_no] [smallint] NULL,
	[current_approver_id] [smallint] NULL,
	[position_id] [smallint] NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleaveovertime_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleaveovertime$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleaveovertime_approvalsequence]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleaveovertime_approvalsequence](
	[id] [int] IDENTITY(71,1) NOT NULL,
	[department_id] [int] NOT NULL,
	[position_id] [int] NOT NULL,
	[approver_id] [int] NOT NULL,
	[sequence_no] [int] NOT NULL,
	[is_final] [int] NOT NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](7) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleaveovertime_approvalsequence_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleaveovertime_approvalsequence$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleaveovertime_finalinform]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleaveovertime_finalinform](
	[id] [int] IDENTITY(2,1) NOT NULL,
	[staff_id] [int] NOT NULL,
	[active] [int] NOT NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleaveovertime_finalinform_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleaveovertime_finalinform$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleaveovertime_history]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleaveovertime_history](
	[id] [int] IDENTITY(20,1) NOT NULL,
	[internalleaveovertime_id] [int] NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staff_id] [int] NOT NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](500) NULL,
	[ipAddress] [nvarchar](16) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleaveovertime_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[internalleaveovertime_id] ASC,
	[requestNo] ASC,
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleaveovertime_history$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleaveovertimedetails_draft]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleaveovertimedetails_draft](
	[id] [int] IDENTITY(22,1) NOT NULL,
	[internalleaveovertime_id] [nvarchar](15) NOT NULL,
	[leavetype_id] [int] NOT NULL,
	[staffId] [nvarchar](11) NOT NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[total] [smallint] NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](1024) NULL,
	[addType] [smallint] NULL,
	[createdBy] [nvarchar](11) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleaveovertimedetails_draft_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[internalleaveovertime_id] ASC,
	[leavetype_id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleaveovertimedetails_draft$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[internalleaveovertimefiled]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[internalleaveovertimefiled](
	[id] [int] IDENTITY(10,1) NOT NULL,
	[requestNo] [nvarchar](15) NULL,
	[dateFiled] [datetime2](0) NULL,
	[notes] [nvarchar](500) NULL,
	[attachment] [nvarchar](500) NULL,
	[ot_type] [nvarchar](10) NOT NULL,
	[isFinalized] [nvarchar](1) NULL,
	[createdBy] [nvarchar](10) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_internalleaveovertimefiled_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [internalleaveovertimefiled$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[jobtitle]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[jobtitle](
	[id] [int] IDENTITY(211,1) NOT NULL,
	[name] [nvarchar](512) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_jobtitle_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [jobtitle$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[leavetype]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[leavetype](
	[id] [int] IDENTITY(18,1) NOT NULL,
	[name] [nvarchar](500) NULL,
	[deductDays] [smallint] NULL,
	[deanApprovalLimit] [smallint] NULL,
	[forMinistry] [smallint] NOT NULL,
	[forCompany] [smallint] NOT NULL,
	[active] [smallint] NOT NULL,
	[rules] [nvarchar](max) NOT NULL,
	[created] [datetime2](0) NOT NULL,
	[modified] [datetime] NOT NULL,
 CONSTRAINT [PK_leavetype_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [leavetype$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[nationality]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[nationality](
	[id] [int] IDENTITY(195,1) NOT NULL,
	[name] [nvarchar](100) NULL,
	[country] [nvarchar](45) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_nationality_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [nationality$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[position_category]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[position_category](
	[id] [smallint] IDENTITY(5,1) NOT NULL,
	[name] [nvarchar](50) NOT NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_position_category_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[qualification]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[qualification](
	[id] [int] IDENTITY(14,1) NOT NULL,
	[name] [nvarchar](512) NOT NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_qualification_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [qualification$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[salarygrade]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[salarygrade](
	[id] [int] IDENTITY(30,1) NOT NULL,
	[code] [nvarchar](100) NULL,
	[name] [nvarchar](100) NULL,
	[salary] [nvarchar](100) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_salarygrade_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [salarygrade$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[section]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[section](
	[id] [int] IDENTITY(36,1) NOT NULL,
	[name] [nvarchar](500) NULL,
	[shortName] [nvarchar](500) NULL,
	[department_id] [int] NOT NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_section_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [section$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[shortleave]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[shortleave](
	[id] [int] IDENTITY(16,1) NOT NULL,
	[requestNo] [nvarchar](20) NULL,
	[staff_id] [int] NOT NULL,
	[currentStatus] [nvarchar](500) NULL,
	[dateFile] [date] NULL,
	[leaveDate] [date] NULL,
	[startTime] [nvarchar](10) NULL,
	[endTime] [nvarchar](10) NULL,
	[total] [nvarchar](10) NULL,
	[reason] [nvarchar](1024) NOT NULL,
	[currentSeqNumber] [smallint] NULL,
	[currentApproverPositionId] [smallint] NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_shortleave_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [shortleave$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[shortleave_history]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[shortleave_history](
	[id] [int] IDENTITY(25,1) NOT NULL,
	[shortleave_id] [int] NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staff_id] [int] NOT NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](500) NULL,
	[ipAddress] [nvarchar](16) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_shortleave_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[shortleave_id] ASC,
	[requestNo] ASC,
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [shortleave_history$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[specialization]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[specialization](
	[id] [int] IDENTITY(152,1) NOT NULL,
	[name] [nvarchar](255) NULL,
	[shortName] [nvarchar](50) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_specialization_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [specialization$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[sponsor]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[sponsor](
	[id] [int] IDENTITY(7,1) NOT NULL,
	[name] [nvarchar](500) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_sponsor_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [sponsor$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staff]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staff](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[staffId] [nvarchar](255) NULL,
	[civilId] [nvarchar](255) NULL,
	[ministryStaffId] [nvarchar](255) NULL,
	[salutation] [nvarchar](255) NULL,
	[firstName] [nvarchar](255) NULL,
	[secondName] [nvarchar](255) NULL,
	[thirdName] [nvarchar](255) NULL,
	[lastName] [nvarchar](255) NULL,
	[firstNameArabic] [nvarchar](255) NULL,
	[secondNameArabic] [nvarchar](255) NULL,
	[thirdNameArabic] [nvarchar](255) NULL,
	[lastNameArabic] [nvarchar](255) NULL,
	[birthdate] [datetime] NULL,
	[gender] [nvarchar](255) NULL,
	[joinDate] [datetime] NULL,
	[maritalStatus] [nvarchar](255) NULL,
	[nationality_id] [float] NULL
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staff_position]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staff_position](
	[id] [int] IDENTITY(81,1) NOT NULL,
	[code] [nvarchar](150) NOT NULL,
	[title] [nvarchar](250) NOT NULL,
	[manager] [int] NOT NULL,
	[active] [int] NOT NULL,
 CONSTRAINT [PK_staff_position_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffextracertificate]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffextracertificate](
	[id] [int] IDENTITY(106,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[extracertificates_id] [int] NOT NULL,
	[certificateNo] [nvarchar](500) NULL,
	[issuedDate] [date] NULL,
	[issuedPlace] [nvarchar](512) NULL,
	[attachment] [nvarchar](512) NULL,
	[created_by] [nvarchar](10) NOT NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_staffextracertificate_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC,
	[extracertificates_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffextracertificate$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[stafffamily]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[stafffamily](
	[id] [int] IDENTITY(1307,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[civilId] [nvarchar](500) NULL,
	[name] [nvarchar](500) NULL,
	[arabicName] [nvarchar](500) NULL,
	[relationship] [nvarchar](500) NULL,
	[gender] [nvarchar](500) NULL,
	[birthdate] [date] NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_stafffamily_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [stafffamily$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffpassport]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffpassport](
	[id] [int] IDENTITY(527,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[stafffamily_id] [int] NOT NULL,
	[number] [nvarchar](20) NULL,
	[issueDate] [date] NULL,
	[expiryDate] [date] NULL,
	[isFamilyMember] [int] NULL,
	[isCurrent] [int] NULL,
	[enteredBy] [nvarchar](20) NULL,
	[created] [datetime2](0) NOT NULL,
	[modified] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_staffpassport_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC,
	[stafffamily_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffpassport$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffpublication]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffpublication](
	[id] [int] IDENTITY(449,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[category] [nvarchar](100) NULL,
	[title] [nvarchar](max) NULL,
	[name] [nvarchar](max) NULL,
	[place] [nvarchar](max) NULL,
	[coAuthors] [nvarchar](max) NULL,
	[copies] [int] NULL,
	[publishDate] [date] NULL,
	[abstract] [nvarchar](max) NULL,
	[attachment] [nvarchar](500) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_staffpublication_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffpublication$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffqualification]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffqualification](
	[id] [int] IDENTITY(1073,1) NOT NULL,
	[staffId] [int] NOT NULL,
	[degree_id] [int] NOT NULL,
	[certificate_id] [int] NOT NULL,
	[graduateYear] [nvarchar](4) NULL,
	[institution] [nvarchar](500) NULL,
	[gpa] [nvarchar](100) NULL,
	[certificateNo] [nvarchar](100) NULL,
	[attachment] [nvarchar](500) NULL,
	[active] [int] NOT NULL,
	[created_by] [nvarchar](10) NOT NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_staffqualification_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[degree_id] ASC,
	[staffId] ASC,
	[certificate_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffqualification$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffresearch]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffresearch](
	[id] [int] IDENTITY(171,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[category] [nvarchar](100) NULL,
	[title] [nvarchar](500) NULL,
	[subject] [nvarchar](250) NULL,
	[organization] [nvarchar](500) NULL,
	[location] [nvarchar](500) NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[abstract] [nvarchar](max) NULL,
	[attachment] [nvarchar](500) NULL,
	[createdBy] [nvarchar](15) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_staffresearch_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffresearch$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[stafftraining]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[stafftraining](
	[id] [int] IDENTITY(1068,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[trainingtype_id] [int] NOT NULL,
	[title] [nvarchar](500) NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[place] [nvarchar](500) NULL,
	[inCollege] [int] NULL,
	[isSponsoredByCollege] [int] NULL,
	[attachment] [nvarchar](500) NULL,
	[createdBy] [nvarchar](15) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_stafftraining_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC,
	[trainingtype_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [stafftraining$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffvisa]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffvisa](
	[id] [int] IDENTITY(504,1) NOT NULL,
	[staffId] [int] NOT NULL,
	[stafffamily_id] [int] NOT NULL,
	[civilId] [nvarchar](12) NULL,
	[cExpiryDate] [date] NULL,
	[number] [nvarchar](20) NULL,
	[issueDate] [date] NULL,
	[expiryDate] [date] NULL,
	[isFamilyMember] [int] NULL,
	[isCurrent] [int] NULL,
	[enteredBy] [nvarchar](50) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_staffvisa_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC,
	[stafffamily_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffvisa$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[staffworkexperience]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[staffworkexperience](
	[id] [int] IDENTITY(1114,1) NOT NULL,
	[staffId] [nvarchar](15) NOT NULL,
	[designation] [nvarchar](500) NULL,
	[organizationName] [nvarchar](500) NULL,
	[organizationType] [nvarchar](500) NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[attachment] [nvarchar](500) NULL,
	[enteredBy] [nvarchar](15) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_staffworkexperience_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [staffworkexperience$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[standardleave]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[standardleave](
	[id] [int] IDENTITY(105,1) NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staff_id] [nvarchar](11) NOT NULL,
	[leavetype_id] [int] NOT NULL,
	[currentStatus] [nvarchar](50) NOT NULL,
	[dateFiled] [datetime2](0) NULL,
	[startDate] [date] NULL,
	[endDate] [date] NULL,
	[total] [smallint] NOT NULL,
	[reason] [nvarchar](1024) NOT NULL,
	[attachment] [nvarchar](500) NULL,
	[current_sequence_no] [smallint] NULL,
	[current_approver_id] [smallint] NULL,
	[position_id] [smallint] NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_standardleave_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[staff_id] ASC,
	[leavetype_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [standardleave$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[standardleave_history]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[standardleave_history](
	[id] [int] IDENTITY(138,1) NOT NULL,
	[standardleave_id] [int] NOT NULL,
	[requestNo] [nvarchar](20) NOT NULL,
	[staff_id] [int] NOT NULL,
	[status] [nvarchar](100) NULL,
	[notes] [nvarchar](500) NULL,
	[ipAddress] [nvarchar](16) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_standardleave_history_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC,
	[standardleave_id] ASC,
	[requestNo] ASC,
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [standardleave_history$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[stat]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[stat](
	[id] [int] IDENTITY(3,1) NOT NULL,
	[name] [nvarchar](10) NOT NULL,
 CONSTRAINT [PK_stat_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[status]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[status](
	[id] [int] IDENTITY(7,1) NOT NULL,
	[name] [nvarchar](45) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_status_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [status$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC,
	[name] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[system_emails]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[system_emails](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[requestNo] [nvarchar](500) NOT NULL,
	[moduleName] [nvarchar](500) NOT NULL,
	[sentStatus] [nvarchar](20) NOT NULL,
	[recipients] [nvarchar](max) NOT NULL,
	[fromName] [nvarchar](100) NOT NULL,
	[comesFrom] [nvarchar](100) NOT NULL,
	[subject] [nvarchar](500) NOT NULL,
	[message] [nvarchar](max) NOT NULL,
	[createdBy] [nvarchar](10) NOT NULL,
	[dateEntered] [datetime2](0) NOT NULL,
	[dateSent] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_system_emails_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY] TEXTIMAGE_ON [PRIMARY]
GO
/****** Object:  Table [dbo].[taskapprover]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[taskapprover](
	[id] [int] IDENTITY(24,1) NOT NULL,
	[task_id] [int] NOT NULL,
	[staff_id] [int] NOT NULL,
	[department_id] [int] NOT NULL,
	[status] [nvarchar](15) NULL,
	[notes] [nvarchar](1024) NOT NULL,
	[createdBy] [nvarchar](15) NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_taskapprover_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [taskapprover$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[tasklist]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[tasklist](
	[id] [smallint] IDENTITY(7,1) NOT NULL,
	[name] [nvarchar](100) NOT NULL,
 CONSTRAINT [PK_tasklist_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[taskprocess]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[taskprocess](
	[id] [int] IDENTITY(22,1) NOT NULL,
	[requestNo] [nvarchar](25) NOT NULL,
	[staff_id] [int] NOT NULL,
	[department_id] [int] NOT NULL,
	[taskProcessStatus] [nvarchar](500) NOT NULL,
	[currentServiceId] [smallint] NOT NULL,
	[currentService] [nvarchar](500) NOT NULL,
	[currentServiceStatus] [nvarchar](500) NULL,
	[started] [datetime2](0) NULL,
	[taskType] [smallint] NOT NULL,
	[created] [datetime2](0) NULL,
	[modified] [datetime2](0) NULL,
 CONSTRAINT [PK_taskprocess_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [taskprocess$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[taskprocesshistory]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[taskprocesshistory](
	[id] [int] IDENTITY(77,1) NOT NULL,
	[taskprocess_id] [int] NOT NULL,
	[task_id] [int] NOT NULL,
	[staff_id] [int] NOT NULL,
	[transactionDate] [datetime2](0) NULL,
	[status] [nvarchar](20) NULL,
	[comments] [nvarchar](500) NULL,
 CONSTRAINT [PK_taskprocesshistory_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [taskprocesshistory$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[trainingtype]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[trainingtype](
	[id] [int] IDENTITY(7,1) NOT NULL,
	[name] [nvarchar](100) NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_trainingtype_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [trainingtype$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[user_types]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[user_types](
	[id] [int] IDENTITY(8,1) NOT NULL,
	[user_type_id] [int] NOT NULL,
	[name] [nvarchar](512) NOT NULL,
	[active] [smallint] NOT NULL,
 CONSTRAINT [PK_user_types_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY],
 CONSTRAINT [user_types$id_UNIQUE] UNIQUE NONCLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  Table [dbo].[users]    Script Date: 25/01/2020 12:56:39 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[users](
	[id] [int] NOT NULL,
	[username] [nvarchar](10) NOT NULL,
	[password] [nvarchar](100) NOT NULL,
	[userType] [int] NOT NULL,
	[status] [int] NOT NULL,
	[created_by] [nvarchar](10) NOT NULL,
	[created] [datetime2](0) NOT NULL,
	[modified] [datetime2](0) NOT NULL,
 CONSTRAINT [PK_users_id] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]
GO
/****** Object:  View [dbo].[v_attendance]    Script Date: 25/01/2020 12:56:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_attendance]
AS
SELECT        userid AS StaffId, recordDate AS Date, CAST(inTime AS time) AS TimeIn, CAST(outTime AS time) AS TimeOut, CASE WHEN (CAST(fpuserlog.outTime AS time) IS NULL OR
                         CAST(fpuserlog.inTime AS time) IS NULL) THEN '00:00:00' ELSE CONVERT(varchar(6), DATEDIFF(SECOND, fpuserlog.inTime, fpuserlog.outTime) / 3600) + ':' + RIGHT('0' + CONVERT(varchar(2), (DATEDIFF(second, 
                         fpuserlog.inTime, fpuserlog.outTime) % 3600) / 60), 2) + ':' + RIGHT('0' + CONVERT(varchar(2), DATEDIFF(second, fpuserlog.inTime, fpuserlog.outTime) % 60), 2) END AS noOfHours, DATEDIFF(MINUTE, inTime, outTime) 
                         / 60.00 AS decimalNoOfHours, CASE WHEN DATEDIFF(MINUTE, fpuserlog.inTime, fpuserlog.outTime) / 60.00 > 7.00 THEN CONVERT(varchar(6), DATEDIFF(SECOND, fpuserlog.inTime, fpuserlog.outTime) / 3600 - 7) 
                         + ':' + RIGHT('0' + CONVERT(varchar(2), (DATEDIFF(second, fpuserlog.inTime, fpuserlog.outTime) % 3600) / 60), 2) + ':' + RIGHT('0' + CONVERT(varchar(2), DATEDIFF(second, fpuserlog.inTime, fpuserlog.outTime) % 60), 2) 
                         ELSE 'N/A' END AS overTime, CASE WHEN DATEDIFF(MINUTE, fpuserlog.inTime, fpuserlog.outTime) / 60.00 < 7.00 THEN 'Y' ELSE 'N' END AS underTime, CASE WHEN (fpuserlog.inEvent IS NULL OR
                         fpuserlog.outEvent IS NULL) THEN 'Y' ELSE 'N' END AS missingTime
FROM            dbo.fpuserlog
GO
/****** Object:  View [dbo].[v_standardleave]    Script Date: 25/01/2020 12:56:40 PM ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE VIEW [dbo].[v_standardleave] as
SELECT        s.id, s.staff_id, concat(sf.firstName,' ',sf.secondName,' ',sf.thirdName,' ',sf.lastName) AS staffName, d.name AS department, sec.name AS section, sp.name AS sponsor, s.requestNo, l.name AS leave_type, CONVERT(VARCHAR(12), s.dateFiled, 103) AS dateFiled, 
                         CONVERT(VARCHAR(12), s.startDate, 103) AS startDate, CONVERT(VARCHAR(12), s.endDate, 103) AS endDate, s.total, s.modified, s.currentStatus
FROM            dbo.standardleave AS s LEFT OUTER JOIN
                         dbo.staff AS sf ON s.staff_id = sf.staffId LEFT OUTER JOIN
                         dbo.leavetype AS l ON s.leavetype_id = l.id LEFT OUTER JOIN
                         dbo.employmentdetail AS e ON e.staff_id = s.staff_id LEFT OUTER JOIN
                         dbo.department AS d ON d.id = e.department_id LEFT OUTER JOIN
                         dbo.section AS sec ON sec.id = e.section_id LEFT OUTER JOIN
                         dbo.sponsor AS sp ON sp.id = e.sponsor_id
WHERE        (e.isCurrent = 1)
GO
/****** Object:  Index [fk_contactdetails_contacttype1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_contactdetails_contacttype1_idx] ON [dbo].[contactdetails]
(
	[contacttype_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_contactdetails_staff1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_contactdetails_staff1_idx] ON [dbo].[contactdetails]
(
	[staff_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_contactdetails_stafffamily1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_contactdetails_stafffamily1_idx] ON [dbo].[contactdetails]
(
	[stafffamily_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [fk_stafffamily_staff1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_stafffamily_staff1_idx] ON [dbo].[stafffamily]
(
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
SET ANSI_PADDING ON
GO
/****** Object:  Index [fk_passport_staff1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_passport_staff1_idx] ON [dbo].[staffpassport]
(
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_passport_stafffamily1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_passport_stafffamily1_idx] ON [dbo].[staffpassport]
(
	[stafffamily_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_visa_staff1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_visa_staff1_idx] ON [dbo].[staffvisa]
(
	[staffId] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_visa_stafffamily1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_visa_stafffamily1_idx] ON [dbo].[staffvisa]
(
	[stafffamily_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
/****** Object:  Index [fk_standardleave_leavetype1_idx]    Script Date: 25/01/2020 12:56:40 PM ******/
CREATE NONCLUSTERED INDEX [fk_standardleave_leavetype1_idx] ON [dbo].[standardleave]
(
	[leavetype_id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, SORT_IN_TEMPDB = OFF, DROP_EXISTING = OFF, ONLINE = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
GO
ALTER TABLE [dbo].[access_menu_left_main] ADD  DEFAULT (N'') FOR [menu_name]
GO
ALTER TABLE [dbo].[access_menu_left_main] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[access_menu_left_main] ADD  DEFAULT (N'413047') FOR [created_by]
GO
ALTER TABLE [dbo].[access_menu_left_main] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[access_menu_left_main] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[access_menu_left_sub] ADD  DEFAULT (N'') FOR [menu_name_sub]
GO
ALTER TABLE [dbo].[access_menu_left_sub] ADD  DEFAULT (N'') FOR [page_name]
GO
ALTER TABLE [dbo].[access_menu_left_sub] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[access_menu_left_sub] ADD  DEFAULT (N'413047') FOR [created_by]
GO
ALTER TABLE [dbo].[access_menu_left_sub] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[access_menu_left_sub] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[access_menu_matrix] ADD  DEFAULT (N'413047') FOR [created_by]
GO
ALTER TABLE [dbo].[access_menu_matrix] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[access_menu_matrix] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[access_menu_matrix_sub] ADD  CONSTRAINT [DF__access_me__creat__5BAD9CC8]  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[access_menu_matrix_sub] ADD  CONSTRAINT [DF__access_me__creat__5CA1C101]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[access_menu_matrix_sub] ADD  CONSTRAINT [DF__access_me__modif__5D95E53A]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave] ADD  CONSTRAINT [DF__approvals__appro__5AB9788F]  DEFAULT ((12)) FOR [approverInSequence2]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave] ADD  CONSTRAINT [DF__approvals__activ__5BAD9CC8]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave] ADD  CONSTRAINT [DF__approvals__creat__5CA1C101]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave] ADD  CONSTRAINT [DF__approvals__creat__5D95E53A]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave] ADD  CONSTRAINT [DF__approvals__modif__5E8A0973]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave_history] ADD  CONSTRAINT [DF__approvals__activ__634EBE90]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave_history] ADD  CONSTRAINT [DF__approvals__notes__6442E2C9]  DEFAULT (N'') FOR [notes]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave_history] ADD  CONSTRAINT [DF__approvals__creat__65370702]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave_history] ADD  CONSTRAINT [DF__approvals__creat__662B2B3B]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[approvalsequence_shortleave_history] ADD  CONSTRAINT [DF__approvals__modif__671F4F74]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[approvalsequence_standard_history] ADD  CONSTRAINT [DF__approvals__activ__681373AD]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[approvalsequence_standard_history] ADD  CONSTRAINT [DF__approvals__notes__690797E6]  DEFAULT (N'') FOR [notes]
GO
ALTER TABLE [dbo].[approvalsequence_standard_history] ADD  CONSTRAINT [DF__approvals__creat__69FBBC1F]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[approvalsequence_standard_history] ADD  CONSTRAINT [DF__approvals__creat__6AEFE058]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[approvalsequence_standard_history] ADD  CONSTRAINT [DF__approvals__modif__6BE40491]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave] ADD  CONSTRAINT [DF__approvals__is_fi__6CD828CA]  DEFAULT ((0)) FOR [is_final]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave] ADD  CONSTRAINT [DF__approvals__creat__6DCC4D03]  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave] ADD  CONSTRAINT [DF__approvals__creat__6EC0713C]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave] ADD  CONSTRAINT [DF__approvals__modif__6FB49575]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave_5] ADD  CONSTRAINT [DF__approvals__is_fi__70A8B9AE]  DEFAULT ((0)) FOR [is_final]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave_5] ADD  CONSTRAINT [DF__approvals__creat__719CDDE7]  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave_5] ADD  CONSTRAINT [DF__approvals__creat__72910220]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[approvalsequence_standardleave_5] ADD  CONSTRAINT [DF__approvals__modif__73852659]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[certificate] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[certificate] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[clearance] ADD  CONSTRAINT [DF_clearance_isCleared]  DEFAULT ((0)) FOR [isCleared]
GO
ALTER TABLE [dbo].[clearance_approval_status] ADD  CONSTRAINT [DF_clearance_approval_status_current_flag]  DEFAULT ((0)) FOR [current_flag]
GO
ALTER TABLE [dbo].[clearance_approver] ADD  CONSTRAINT [DF_clearance_approver_sequence_no]  DEFAULT ((0)) FOR [sequence_no]
GO
ALTER TABLE [dbo].[clearance_approver] ADD  CONSTRAINT [DF_clearance_approver_created]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[clearance_approver] ADD  CONSTRAINT [DF_clearance_approver_modified]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[contactdetails] ADD  DEFAULT (NULL) FOR [data]
GO
ALTER TABLE [dbo].[contactdetails] ADD  DEFAULT (NULL) FOR [isCurrent]
GO
ALTER TABLE [dbo].[contactdetails] ADD  DEFAULT (NULL) FOR [isFamily]
GO
ALTER TABLE [dbo].[contacttype] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[contacttype] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[degree] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[degree] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT ((0)) FOR [shl]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT ((0)) FOR [stl]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT ((0)) FOR [otl]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT ((0)) FOR [clr]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (N'') FOR [staffIdFrom]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (N'') FOR [staffIdTo]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (N'') FOR [status]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (NULL) FOR [reason]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[delegation] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[delegation_history] ADD  DEFAULT (NULL) FOR [status]
GO
ALTER TABLE [dbo].[delegation_history] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[delegation_history] ADD  DEFAULT (NULL) FOR [ipAddress]
GO
ALTER TABLE [dbo].[delegation_history] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[delegation_history] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[delegation_pages] ADD  DEFAULT ((0)) FOR [active]
GO
ALTER TABLE [dbo].[delegation_pages] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[delegation_pages] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[delegation_pages] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT ((0)) FOR [delegation_id]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT ((0)) FOR [delegation_pages_id]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT ((0)) FOR [access_menu_left_sub_id]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT ((0)) FOR [user_type]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[delegation_pages_access] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[department] ADD  CONSTRAINT [DF__department__name__16CE6296]  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[department] ADD  CONSTRAINT [DF__departmen__short__17C286CF]  DEFAULT (NULL) FOR [shortName]
GO
ALTER TABLE [dbo].[department] ADD  CONSTRAINT [DF__departmen__isAca__18B6AB08]  DEFAULT (NULL) FOR [isAcademic]
GO
ALTER TABLE [dbo].[department] ADD  CONSTRAINT [DF__departmen__manag__19AACF41]  DEFAULT (N'') FOR [managerId]
GO
ALTER TABLE [dbo].[department] ADD  CONSTRAINT [DF__departmen__activ__1A9EF37A]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[e_forms] ADD  CONSTRAINT [DF_e_forms_created]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[e_forms] ADD  CONSTRAINT [DF_e_forms_modified]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[e_forms_request] ADD  CONSTRAINT [DF_e_forms_request_created]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[e_forms_request] ADD  CONSTRAINT [DF_e_forms_request_modified]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (N'') FOR [emergencyleavebalance_id]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT ((0)) FOR [total]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (N'') FOR [status]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT ((1)) FOR [addType]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[emergencyleavebalancedetails] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[emergencyleavereset] ADD  CONSTRAINT [DF__emergency__reque__2EA5EC27]  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[emergencyleavereset] ADD  CONSTRAINT [DF__emergency__spons__2F9A1060]  DEFAULT (N'Ministry') FOR [sponsorType]
GO
ALTER TABLE [dbo].[emergencyleavereset] ADD  CONSTRAINT [DF__emergency__dateF__308E3499]  DEFAULT (getdate()) FOR [dateFiled]
GO
ALTER TABLE [dbo].[emergencyleavereset] ADD  CONSTRAINT [DF__emergency__creat__318258D2]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[emergencyleavereset] ADD  CONSTRAINT [DF__emergency__creat__32767D0B]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[emergencyleavereset] ADD  CONSTRAINT [DF__emergency__modif__336AA144]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__regis__2AD55B43]  DEFAULT (N'') FOR [registrationCardNo]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__joinD__2BC97F7C]  DEFAULT (NULL) FOR [joinDate]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__isCur__2CBDA3B5]  DEFAULT ((0)) FOR [isCurrent]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__statu__2DB1C7EE]  DEFAULT ((0)) FOR [status_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__depar__2EA5EC27]  DEFAULT ((0)) FOR [department_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__secti__2F9A1060]  DEFAULT ((0)) FOR [section_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__jobti__308E3499]  DEFAULT ((0)) FOR [jobtitle_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__spons__318258D2]  DEFAULT ((0)) FOR [sponsor_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__salar__32767D0B]  DEFAULT ((0)) FOR [salarygrade_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__emplo__336AA144]  DEFAULT ((0)) FOR [employmenttype_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__speci__345EC57D]  DEFAULT ((0)) FOR [specialization_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__quali__3552E9B6]  DEFAULT ((0)) FOR [qualification_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__posit__36470DEF]  DEFAULT ((0)) FOR [position_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__posit__373B3228]  DEFAULT ((0)) FOR [position_category_id]
GO
ALTER TABLE [dbo].[employmentdetail] ADD  CONSTRAINT [DF__employmen__modif__382F5661]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[exit_interview] ADD  CONSTRAINT [DF_exit_interview_aTick1]  DEFAULT ((0)) FOR [aTick1]
GO
ALTER TABLE [dbo].[extracertificates] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[extracertificates] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[fpuserlog] ADD  CONSTRAINT [DF__fpuserlog__synct__44952D46]  DEFAULT (getdate()) FOR [synctime]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__arabicN__3BFFE745]  DEFAULT (N'') FOR [arabicName]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__startDa__3CF40B7E]  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__endDate__3DE82FB7]  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__total__3EDC53F0]  DEFAULT ((0)) FOR [total]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__isRamad__3FD07829]  DEFAULT ((0)) FOR [isRamadan]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__created__40C49C62]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__created__41B8C09B]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[holiday] ADD  CONSTRAINT [DF__holiday__modifie__42ACE4D4]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__reque__4D2A7347]  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__spons__4E1E9780]  DEFAULT ((1)) FOR [sponsorType]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__dateF__4F12BBB9]  DEFAULT (getdate()) FOR [dateFiled]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__notes__5006DFF2]  DEFAULT (N'') FOR [notes]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__attac__50FB042B]  DEFAULT (N'') FOR [attachment]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__isFin__51EF2864]  DEFAULT (N'N') FOR [isFinalized]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__creat__52E34C9D]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__creat__53D770D6]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleavebalance] ADD  CONSTRAINT [DF__internall__modif__54CB950F]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (N'') FOR [internalleavebalance_id]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT ((0)) FOR [total]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (N'') FOR [status]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT ((1)) FOR [addType]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleavebalancedetails] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (N'') FOR [internalleavebalance_id]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT ((0)) FOR [total]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (N'') FOR [status]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT ((1)) FOR [addType]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleavebalancedetails_draft] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleaveovertime] ADD  DEFAULT (N'') FOR [staff_id]
GO
ALTER TABLE [dbo].[internalleaveovertime] ADD  DEFAULT ((0)) FOR [current_sequence_no]
GO
ALTER TABLE [dbo].[internalleaveovertime] ADD  DEFAULT ((0)) FOR [current_approver_id]
GO
ALTER TABLE [dbo].[internalleaveovertime] ADD  DEFAULT ((0)) FOR [position_id]
GO
ALTER TABLE [dbo].[internalleaveovertime] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleaveovertime] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleaveovertime_approvalsequence] ADD  DEFAULT ((0)) FOR [is_final]
GO
ALTER TABLE [dbo].[internalleaveovertime_approvalsequence] ADD  DEFAULT (NULL) FOR [created_by]
GO
ALTER TABLE [dbo].[internalleaveovertime_approvalsequence] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleaveovertime_approvalsequence] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleaveovertime_finalinform] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[internalleaveovertime_finalinform] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleaveovertime_finalinform] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleaveovertime_history] ADD  DEFAULT (NULL) FOR [status]
GO
ALTER TABLE [dbo].[internalleaveovertime_history] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[internalleaveovertime_history] ADD  DEFAULT (NULL) FOR [ipAddress]
GO
ALTER TABLE [dbo].[internalleaveovertime_history] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleaveovertime_history] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (N'') FOR [internalleaveovertime_id]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT ((1)) FOR [leavetype_id]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT ((0)) FOR [total]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (NULL) FOR [status]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT ((1)) FOR [addType]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleaveovertimedetails_draft] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (getdate()) FOR [dateFiled]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (N'') FOR [notes]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (N'') FOR [attachment]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (N'') FOR [ot_type]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (N'N') FOR [isFinalized]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[internalleaveovertimefiled] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[jobtitle] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[jobtitle] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT (NULL) FOR [deductDays]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT (NULL) FOR [deanApprovalLimit]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT ((1)) FOR [forMinistry]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT ((1)) FOR [forCompany]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[leavetype] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[nationality] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[nationality] ADD  DEFAULT (NULL) FOR [country]
GO
ALTER TABLE [dbo].[nationality] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[position_category] ADD  DEFAULT (N'') FOR [name]
GO
ALTER TABLE [dbo].[position_category] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[qualification] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[salarygrade] ADD  DEFAULT (NULL) FOR [code]
GO
ALTER TABLE [dbo].[salarygrade] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[salarygrade] ADD  DEFAULT (NULL) FOR [salary]
GO
ALTER TABLE [dbo].[salarygrade] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[section] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[section] ADD  DEFAULT (NULL) FOR [shortName]
GO
ALTER TABLE [dbo].[section] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (N'') FOR [currentStatus]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (NULL) FOR [dateFile]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (NULL) FOR [leaveDate]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (N'') FOR [startTime]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (N'') FOR [endTime]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (N'') FOR [total]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (N'') FOR [reason]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT ((0)) FOR [currentSeqNumber]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT ((0)) FOR [currentApproverPositionId]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[shortleave] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[shortleave_history] ADD  DEFAULT (NULL) FOR [status]
GO
ALTER TABLE [dbo].[shortleave_history] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[shortleave_history] ADD  DEFAULT (NULL) FOR [ipAddress]
GO
ALTER TABLE [dbo].[shortleave_history] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[shortleave_history] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[specialization] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[specialization] ADD  DEFAULT (NULL) FOR [shortName]
GO
ALTER TABLE [dbo].[specialization] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[sponsor] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[sponsor] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[staff_position] ADD  CONSTRAINT [DF__staff_posi__code__408F9238]  DEFAULT (N'') FOR [code]
GO
ALTER TABLE [dbo].[staff_position] ADD  CONSTRAINT [DF__staff_pos__title__4183B671]  DEFAULT (N'') FOR [title]
GO
ALTER TABLE [dbo].[staff_position] ADD  CONSTRAINT [DF__staff_pos__activ__4277DAAA]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__certi__436BFEE3]  DEFAULT (N'') FOR [certificateNo]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__issue__4460231C]  DEFAULT (NULL) FOR [issuedDate]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__issue__45544755]  DEFAULT (N'') FOR [issuedPlace]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__attac__46486B8E]  DEFAULT (N'') FOR [attachment]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__creat__473C8FC7]  DEFAULT (N'') FOR [created_by]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__creat__4830B400]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffextracertificate] ADD  CONSTRAINT [DF__staffextr__modif__4924D839]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__civil__4A18FC72]  DEFAULT (NULL) FOR [civilId]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffamil__name__4B0D20AB]  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__arabi__4C0144E4]  DEFAULT (N'') FOR [arabicName]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__relat__4CF5691D]  DEFAULT (NULL) FOR [relationship]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__gende__4DE98D56]  DEFAULT (NULL) FOR [gender]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__birth__4EDDB18F]  DEFAULT (NULL) FOR [birthdate]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__creat__4FD1D5C8]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[stafffamily] ADD  CONSTRAINT [DF__stafffami__modif__50C5FA01]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__numbe__51BA1E3A]  DEFAULT (NULL) FOR [number]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__issue__52AE4273]  DEFAULT (NULL) FOR [issueDate]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__expir__53A266AC]  DEFAULT (NULL) FOR [expiryDate]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__isFam__54968AE5]  DEFAULT ((1)) FOR [isFamilyMember]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__isCur__558AAF1E]  DEFAULT ((1)) FOR [isCurrent]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__creat__567ED357]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffpassport] ADD  CONSTRAINT [DF__staffpass__modif__5772F790]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__categ__58671BC9]  DEFAULT (NULL) FOR [category]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__title__595B4002]  DEFAULT (NULL) FOR [title]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubli__name__5A4F643B]  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__place__5B438874]  DEFAULT (NULL) FOR [place]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__coAut__5C37ACAD]  DEFAULT (NULL) FOR [coAuthors]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__copie__5D2BD0E6]  DEFAULT (NULL) FOR [copies]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__publi__5E1FF51F]  DEFAULT (NULL) FOR [publishDate]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__attac__5F141958]  DEFAULT (NULL) FOR [attachment]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__creat__60083D91]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffpublication] ADD  CONSTRAINT [DF__staffpubl__modif__60FC61CA]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__gradu__61F08603]  DEFAULT (NULL) FOR [graduateYear]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__insti__62E4AA3C]  DEFAULT (NULL) FOR [institution]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqualif__gpa__63D8CE75]  DEFAULT (NULL) FOR [gpa]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__certi__64CCF2AE]  DEFAULT (NULL) FOR [certificateNo]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__attac__65C116E7]  DEFAULT (NULL) FOR [attachment]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__activ__66B53B20]  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__creat__67A95F59]  DEFAULT (N'') FOR [created_by]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__creat__689D8392]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffqualification] ADD  CONSTRAINT [DF__staffqual__modif__6991A7CB]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__categ__6A85CC04]  DEFAULT (N'') FOR [category]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__title__6B79F03D]  DEFAULT (N'') FOR [title]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__subje__6C6E1476]  DEFAULT (N'') FOR [subject]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__organ__6D6238AF]  DEFAULT (N'') FOR [organization]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__locat__6E565CE8]  DEFAULT (N'') FOR [location]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__start__6F4A8121]  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__endDa__703EA55A]  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__attac__7132C993]  DEFAULT (N'') FOR [attachment]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__creat__7226EDCC]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffresearch] ADD  CONSTRAINT [DF__staffrese__modif__731B1205]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__title__740F363E]  DEFAULT (NULL) FOR [title]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__start__75035A77]  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__endDa__75F77EB0]  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__place__76EBA2E9]  DEFAULT (NULL) FOR [place]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__inCol__77DFC722]  DEFAULT ((0)) FOR [inCollege]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__isSpo__78D3EB5B]  DEFAULT ((0)) FOR [isSponsoredByCollege]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__attac__79C80F94]  DEFAULT (NULL) FOR [attachment]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__creat__7ABC33CD]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[stafftraining] ADD  CONSTRAINT [DF__stafftrai__modif__7BB05806]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__civil__7CA47C3F]  DEFAULT (N'') FOR [civilId]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__cExpi__7D98A078]  DEFAULT (NULL) FOR [cExpiryDate]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__numbe__7E8CC4B1]  DEFAULT (N'') FOR [number]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__issue__7F80E8EA]  DEFAULT (NULL) FOR [issueDate]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__expir__00750D23]  DEFAULT (NULL) FOR [expiryDate]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__isFam__0169315C]  DEFAULT ((1)) FOR [isFamilyMember]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__isCur__025D5595]  DEFAULT ((1)) FOR [isCurrent]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__creat__035179CE]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffvisa] ADD  CONSTRAINT [DF__staffvisa__modif__04459E07]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__desig__0539C240]  DEFAULT (N'') FOR [designation]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__organ__062DE679]  DEFAULT (N'') FOR [organizationName]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__organ__07220AB2]  DEFAULT (N'') FOR [organizationType]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__start__08162EEB]  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__endDa__090A5324]  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__attac__09FE775D]  DEFAULT (N'') FOR [attachment]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__creat__0AF29B96]  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[staffworkexperience] ADD  CONSTRAINT [DF__staffwork__modif__0BE6BFCF]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (N'') FOR [staff_id]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT ((0)) FOR [leavetype_id]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (NULL) FOR [dateFiled]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (NULL) FOR [startDate]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (NULL) FOR [endDate]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT ((0)) FOR [total]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (N'') FOR [attachment]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT ((0)) FOR [current_sequence_no]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT ((0)) FOR [current_approver_id]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT ((0)) FOR [position_id]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[standardleave] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[standardleave_history] ADD  DEFAULT (NULL) FOR [status]
GO
ALTER TABLE [dbo].[standardleave_history] ADD  DEFAULT (NULL) FOR [notes]
GO
ALTER TABLE [dbo].[standardleave_history] ADD  DEFAULT (NULL) FOR [ipAddress]
GO
ALTER TABLE [dbo].[standardleave_history] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[standardleave_history] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[stat] ADD  DEFAULT (N'') FOR [name]
GO
ALTER TABLE [dbo].[status] ADD  DEFAULT (NULL) FOR [name]
GO
ALTER TABLE [dbo].[status] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__reque__1758727B]  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__modul__184C96B4]  DEFAULT (N'') FOR [moduleName]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__sentS__1940BAED]  DEFAULT (N'') FOR [sentStatus]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__fromN__1A34DF26]  DEFAULT (N'') FOR [fromName]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__comes__1B29035F]  DEFAULT (N'') FOR [comesFrom]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__subje__1C1D2798]  DEFAULT (N'') FOR [subject]
GO
ALTER TABLE [dbo].[system_emails] ADD  CONSTRAINT [DF__system_em__creat__1D114BD1]  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[taskapprover] ADD  DEFAULT (N'') FOR [status]
GO
ALTER TABLE [dbo].[taskapprover] ADD  DEFAULT (N'-') FOR [notes]
GO
ALTER TABLE [dbo].[taskapprover] ADD  DEFAULT (N'') FOR [createdBy]
GO
ALTER TABLE [dbo].[taskapprover] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[taskapprover] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[tasklist] ADD  DEFAULT (N'') FOR [name]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (N'') FOR [requestNo]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (N'') FOR [taskProcessStatus]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (N'') FOR [currentService]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (N'') FOR [currentServiceStatus]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (NULL) FOR [started]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (getdate()) FOR [created]
GO
ALTER TABLE [dbo].[taskprocess] ADD  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[taskprocesshistory] ADD  DEFAULT (getdate()) FOR [transactionDate]
GO
ALTER TABLE [dbo].[taskprocesshistory] ADD  DEFAULT (N'') FOR [status]
GO
ALTER TABLE [dbo].[taskprocesshistory] ADD  DEFAULT (N'') FOR [comments]
GO
ALTER TABLE [dbo].[trainingtype] ADD  DEFAULT (N'') FOR [name]
GO
ALTER TABLE [dbo].[trainingtype] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[user_types] ADD  DEFAULT ((1)) FOR [active]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF__users__userType__38B96646]  DEFAULT ((6)) FOR [userType]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF__users__status__39AD8A7F]  DEFAULT ((1)) FOR [status]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF__users__created_b__3AA1AEB8]  DEFAULT (N'') FOR [created_by]
GO
ALTER TABLE [dbo].[users] ADD  CONSTRAINT [DF__users__modified__3B95D2F1]  DEFAULT (getdate()) FOR [modified]
GO
ALTER TABLE [dbo].[contactdetails]  WITH NOCHECK ADD  CONSTRAINT [contactdetails$fk_contactdetails_contacttype1] FOREIGN KEY([contacttype_id])
REFERENCES [dbo].[contacttype] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[contactdetails] CHECK CONSTRAINT [contactdetails$fk_contactdetails_contacttype1]
GO
ALTER TABLE [dbo].[standardleave]  WITH NOCHECK ADD  CONSTRAINT [standardleave$fk_standardleave_leavetype1] FOREIGN KEY([leavetype_id])
REFERENCES [dbo].[leavetype] ([id])
ON UPDATE CASCADE
ON DELETE CASCADE
GO
ALTER TABLE [dbo].[standardleave] CHECK CONSTRAINT [standardleave$fk_standardleave_leavetype1]
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.access_menu_left_main' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_menu_left_main'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.access_menu_left_sub' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_menu_left_sub'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.access_menu_matrix' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_menu_matrix'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.access_menu_matrix_sub' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'access_menu_matrix_sub'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.approvalsequence_shortleave' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'approvalsequence_shortleave'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.approvalsequence_shortleave_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'approvalsequence_shortleave_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.approvalsequence_standard_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'approvalsequence_standard_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.approvalsequence_standardleave' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'approvalsequence_standardleave'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.approvalsequence_standardleave_5' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'approvalsequence_standardleave_5'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.certificate' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'certificate'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.contactdetails' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'contactdetails'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.contacttype' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'contacttype'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.degree' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'degree'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.delegation' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'delegation'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.delegation_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'delegation_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.delegation_pages' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'delegation_pages'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.delegation_pages_access' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'delegation_pages_access'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.department' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'department'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.emergencyleavebalancedetails' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'emergencyleavebalancedetails'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.emergencyleavereset' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'emergencyleavereset'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.employmentdetail' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'employmentdetail'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.extracertificates' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'extracertificates'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.fpuserlog' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'fpuserlog'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.holiday' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'holiday'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleavebalance' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleavebalance'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleavebalancedetails' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleavebalancedetails'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleavebalancedetails_draft' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleavebalancedetails_draft'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleaveovertime' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleaveovertime'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleaveovertime_approvalsequence' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleaveovertime_approvalsequence'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleaveovertime_finalinform' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleaveovertime_finalinform'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleaveovertime_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleaveovertime_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleaveovertimedetails_draft' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleaveovertimedetails_draft'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.internalleaveovertimefiled' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'internalleaveovertimefiled'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.jobtitle' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'jobtitle'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.leavetype' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'leavetype'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.nationality' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'nationality'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.position_category' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'position_category'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.qualification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'qualification'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.salarygrade' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'salarygrade'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.section' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'section'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.shortleave' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'shortleave'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.shortleave_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'shortleave_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.specialization' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'specialization'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.sponsor' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'sponsor'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staff_position' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staff_position'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffextracertificate' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffextracertificate'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.stafffamily' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'stafffamily'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffpassport' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffpassport'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffpublication' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffpublication'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffqualification' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffqualification'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffresearch' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffresearch'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.stafftraining' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'stafftraining'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffvisa' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffvisa'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.staffworkexperience' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'staffworkexperience'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.standardleave' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'standardleave'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.standardleave_history' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'standardleave_history'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'stat' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'stat'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.status' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'status'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.system_emails' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'system_emails'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.taskapprover' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'taskapprover'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.tasklist' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'tasklist'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.taskprocess' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'taskprocess'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.taskprocesshistory' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'taskprocesshistory'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.trainingtype' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'trainingtype'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.user_types' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'user_types'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_SSMA_SOURCE', @value=N'dbhr3_test.users' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'TABLE',@level1name=N'users'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPane1', @value=N'[0E232FF0-B466-11cf-A24F-00AA00A3EFFF, 1.00]
Begin DesignProperties = 
   Begin PaneConfigurations = 
      Begin PaneConfiguration = 0
         NumPanes = 4
         Configuration = "(H (1[17] 4[33] 2[38] 3) )"
      End
      Begin PaneConfiguration = 1
         NumPanes = 3
         Configuration = "(H (1 [50] 4 [25] 3))"
      End
      Begin PaneConfiguration = 2
         NumPanes = 3
         Configuration = "(H (1 [50] 2 [25] 3))"
      End
      Begin PaneConfiguration = 3
         NumPanes = 3
         Configuration = "(H (4 [30] 2 [40] 3))"
      End
      Begin PaneConfiguration = 4
         NumPanes = 2
         Configuration = "(H (1 [56] 3))"
      End
      Begin PaneConfiguration = 5
         NumPanes = 2
         Configuration = "(H (2 [66] 3))"
      End
      Begin PaneConfiguration = 6
         NumPanes = 2
         Configuration = "(H (4 [50] 3))"
      End
      Begin PaneConfiguration = 7
         NumPanes = 1
         Configuration = "(V (3))"
      End
      Begin PaneConfiguration = 8
         NumPanes = 3
         Configuration = "(H (1[56] 4[18] 2) )"
      End
      Begin PaneConfiguration = 9
         NumPanes = 2
         Configuration = "(H (1 [75] 4))"
      End
      Begin PaneConfiguration = 10
         NumPanes = 2
         Configuration = "(H (1[66] 2) )"
      End
      Begin PaneConfiguration = 11
         NumPanes = 2
         Configuration = "(H (4 [60] 2))"
      End
      Begin PaneConfiguration = 12
         NumPanes = 1
         Configuration = "(H (1) )"
      End
      Begin PaneConfiguration = 13
         NumPanes = 1
         Configuration = "(V (4))"
      End
      Begin PaneConfiguration = 14
         NumPanes = 1
         Configuration = "(V (2))"
      End
      ActivePaneConfig = 0
   End
   Begin DiagramPane = 
      Begin Origin = 
         Top = 0
         Left = 0
      End
      Begin Tables = 
         Begin Table = "fpuserlog"
            Begin Extent = 
               Top = 6
               Left = 38
               Bottom = 136
               Right = 208
            End
            DisplayFlags = 280
            TopColumn = 0
         End
      End
   End
   Begin SQLPane = 
   End
   Begin DataPane = 
      Begin ParameterDefaults = ""
      End
   End
   Begin CriteriaPane = 
      Begin ColumnWidths = 11
         Column = 1440
         Alias = 900
         Table = 1170
         Output = 720
         Append = 1400
         NewValue = 1170
         SortType = 1350
         SortOrder = 1410
         GroupBy = 1350
         Filter = 1350
         Or = 1350
         Or = 1350
         Or = 1350
      End
   End
End
' , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_attendance'
GO
EXEC sys.sp_addextendedproperty @name=N'MS_DiagramPaneCount', @value=1 , @level0type=N'SCHEMA',@level0name=N'dbo', @level1type=N'VIEW',@level1name=N'v_attendance'
GO
USE [master]
GO
ALTER DATABASE [dbhr3_test] SET  READ_WRITE 
GO
