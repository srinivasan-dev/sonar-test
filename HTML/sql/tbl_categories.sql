CREATE TABLE `tbl_categories` (
  `id` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `short_description` varchar(255) NOT NULL,
  `redirect_url` varchar(255) NOT NULL,
  `favicon` varchar(255) NOT NULL,
  `PRIMARY KEY` (`id`),
  `UNIQUE KEY` `category` (`category`);

) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tbl_categories`
--

INSERT INTO `tbl_categories` (`id`, `category`, `short_description`, `redirect_url`, `favicon`) VALUES
(1, '.NET Programmer', 'TBD:- .NET Programmer short description', '.NET+Programmer', 'fa fa-desktop'),
(2, 'Database Specialist', 'TBD:- Database Specialist short description', 'Database+Specialist', 'fa fa-database'),
(3, 'Business Intelligence Specialist', 'TBD:- Business Intelligence Specialist short description', 'Business+Intelligence+Specialist', 'fa fa-briefcase'),
(4, 'Big Data Specialist', 'TBD:- Big Data Specialist short description', 'Big+Data+Specialist', 'fa fa-folder'),
(5, 'Cloud Programmer', 'TBD:- Cloud Programmer short description', 'Cloud+Programmer', 'fa fa-cloud'),
(6, 'Java Programmer', 'TBD:- Java Programmer short description', 'Java+Programmer', 'fa fa-pencil'),
(7, 'UNIX Programmer', 'TBD:- UNIX Programmer short description', 'UNIX+Programmer', 'fa fa-user-circle'),
(8, 'Project Management', 'TBD:- Project Management short description', 'Project+Management', 'fa fa-users'),
(9, 'Testing Engineer', 'TBD: Short description for Testing Engineer', 'Testing+Engineer', '');

--
-- Indexes for dumped tables
--

