<?php

$pre        = $inst->rfk_db['dbprefix'];

$sql_create_groups = "
        CREATE TABLE IF NOT EXISTS `{$pre}groups` (
          `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
          `name` varchar(20) NOT NULL,
          `description` varchar(100) NOT NULL,
          PRIMARY KEY (`id`)
        ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;";


$sql_insert_groups = "
    INSERT INTO `{$pre}groups` (`id`, `name`, `description`) VALUES
    (1, 'admin', 'Administrator'),
    (2, 'manager', 'Managers'),
    (3, 'developer', 'Developer'),
    (4, 'guest', 'Guest');";
    

$sql_create_country = "
    CREATE TABLE IF NOT EXISTS `{$pre}country` (
        `country_id` char(2) NOT NULL default '',
        `name` varchar(100) NOT NULL default '',
        PRIMARY KEY  (`country_id`)
      );";

$sql_insert_country = "
    INSERT INTO `{$pre}country` (`country_id`, `name`) VALUES 
    ('AF', 'Afghanistan'),
    ('AL', 'Albania'),
    ('DZ', 'Algeria'),
    ('AS', 'American samoa'),
    ('AD', 'Andorra'),
    ('AO', 'Angola'),
    ('AI', 'Anguilla'),
    ('AQ', 'Antarctica'),
    ('AG', 'Antigua and barbuda'),
    ('AR', 'Argentina'),
    ('AM', 'Armenia'),
    ('AW', 'Aruba'),
    ('AU', 'Australia'),
    ('AT', 'Austria'),
    ('AZ', 'Azerbaijan'),
    ('BS', 'Bahamas'),
    ('BH', 'Bahrain'),
    ('BD', 'Bangladesh'),
    ('BB', 'Barbados'),
    ('BY', 'Belarus'),
    ('BE', 'Belgium'),
    ('BZ', 'Belize'),
    ('BJ', 'Benin'),
    ('BM', 'Bermuda'),
    ('BT', 'Bhutan'),
    ('BO', 'Bolivia'),
    ('BA', 'Bosnia and herzegovina'),
    ('BW', 'Botswana'),
    ('BV', 'Bouvet island'),
    ('BR', 'Brazil'),
    ('IO', 'British indian ocean territory'),
    ('BN', 'Brunei darussalam'),
    ('BG', 'Bulgaria'),
    ('BF', 'Burkina faso'),
    ('BI', 'Burundi'),
    ('KH', 'Cambodia'),
    ('CM', 'Cameroon'),
    ('CA', 'Canada'),
    ('CV', 'Cape verde'),
    ('KY', 'Cayman islands'),
    ('CF', 'Central african republic'),
    ('TD', 'Chad'),
    ('CL', 'Chile'),
    ('CN', 'China'),
    ('CX', 'Christmas island'),
    ('CC', 'Cocos (keeling) islands'),
    ('CO', 'Colombia'),
    ('KM', 'Comoros'),
    ('CG', 'Congo'),
    ('CD', 'Congo'),
    ('CK', 'Cook islands'),
    ('CR', 'Costa rica'),
    ('CI', 'Cote d''ivoire'),
    ('HR', 'Croatia'),
    ('CU', 'Cuba'),
    ('CY', 'Cyprus'),
    ('CZ', 'Czech republic'),
    ('DK', 'Denmark'),
    ('DJ', 'Djibouti'),
    ('DM', 'Dominica'),
    ('DO', 'Dominican republic'),
    ('TP', 'East timor'),
    ('EC', 'Ecuador'),
    ('EG', 'Egypt'),
    ('SV', 'El salvador'),
    ('GQ', 'Equatorial guinea'),
    ('ER', 'Eritrea'),
    ('EE', 'Estonia'),
    ('ET', 'Ethiopia'),
    ('FK', 'Falkland islands (malvinas)'),
    ('FO', 'Faroe islands'),
    ('FJ', 'Fiji'),
    ('FI', 'Finland'),
    ('FR', 'France'),
    ('GF', 'French guiana'),
    ('PF', 'French polynesia'),
    ('TF', 'French southern territories'),
    ('GA', 'Gabon'),
    ('GM', 'Gambia'),
    ('GE', 'Georgia'),
    ('DE', 'Germany'),
    ('GH', 'Ghana'),
    ('GI', 'Gibraltar'),
    ('GR', 'Greece'),
    ('GL', 'Greenland'),
    ('GD', 'Grenada'),
    ('GP', 'Guadeloupe'),
    ('GU', 'Guam'),
    ('GT', 'Guatemala'),
    ('GN', 'Guinea'),
    ('GW', 'Guinea-bissau'),
    ('GY', 'Guyana'),
    ('HT', 'Haiti'),
    ('HM', 'Heard and mcdonald islands'),
    ('VA', 'Holy see (vatican city state)'),
    ('HN', 'Honduras'),
    ('HK', 'Hong kong'),
    ('HU', 'Hungary'),
    ('IS', 'Iceland'),
    ('IN', 'India'),
    ('ID', 'Indonesia'),
    ('IR', 'Iran, islamic republic of'),
    ('IQ', 'Iraq'),
    ('IE', 'Ireland'),
    ('IL', 'Israel'),
    ('IT', 'Italy'),
    ('JM', 'Jamaica'),
    ('JP', 'Japan'),
    ('JO', 'Jordan'),
    ('KZ', 'Kazakstan'),
    ('KE', 'Kenya'),
    ('KI', 'Kiribati'),
    ('KP', 'Korea, democratic'),
    ('KR', 'Korea, republic of'),
    ('KW', 'Kuwait'),
    ('KG', 'Kyrgyzstan'),
    ('LA', 'Laos'),
    ('LV', 'Latvia'),
    ('LB', 'Lebanon'),
    ('LS', 'Lesotho'),
    ('LR', 'Liberia'),
    ('LY', 'Libyan arab jamahiriya'),
    ('LI', 'Liechtenstein'),
    ('LT', 'Lithuania'),
    ('LU', 'Luxembourg'),
    ('MO', 'Macau'),
    ('MK', 'Macedonia'),
    ('MG', 'Madagascar'),
    ('MW', 'Malawi'),
    ('MY', 'Malaysia'),
    ('MV', 'Maldives'),
    ('ML', 'Mali'),
    ('MT', 'Malta'),
    ('MH', 'Marshall islands'),
    ('MQ', 'Martinique'),
    ('MR', 'Mauritania'),
    ('MU', 'Mauritius'),
    ('YT', 'Mayotte'),
    ('MX', 'Mexico'),
    ('FM', 'Micronesia'),
    ('MD', 'Moldova, republic of'),
    ('MC', 'Monaco'),
    ('MN', 'Mongolia'),
    ('MS', 'Montserrat'),
    ('MA', 'Morocco'),
    ('MZ', 'Mozambique'),
    ('MM', 'Myanmar'),
    ('NA', 'Namibia'),
    ('NR', 'Nauru'),
    ('NP', 'Nepal'),
    ('NL', 'Netherlands'),
    ('AN', 'Netherlands antilles'),
    ('NC', 'New caledonia'),
    ('NZ', 'New zealand'),
    ('NI', 'Nicaragua'),
    ('NE', 'Niger'),
    ('NG', 'Nigeria'),
    ('NU', 'Niue'),
    ('NF', 'Norfolk island'),
    ('MP', 'Northern mariana islands'),
    ('NO', 'Norway'),
    ('OM', 'Oman'),
    ('PK', 'Pakistan'),
    ('PW', 'Palau'),
    ('PS', 'Palestinian territory'),
    ('PA', 'Panama'),
    ('PG', 'Papua new guinea'),
    ('PY', 'Paraguay'),
    ('PE', 'Peru'),
    ('PH', 'Philippines'),
    ('PN', 'Pitcairn'),
    ('PL', 'Poland'),
    ('PT', 'Portugal'),
    ('PR', 'Puerto rico'),
    ('QA', 'Qatar'),
    ('RE', 'Reunion'),
    ('RO', 'Romania'),
    ('RU', 'Russian federation'),
    ('RW', 'Rwanda'),
    ('SH', 'Saint helena'),
    ('KN', 'Saint kitts and nevis'),
    ('LC', 'Saint lucia'),
    ('PM', 'Saint pierre and miquelon'),
    ('VC', 'Saint vincent and the grenadines'),
    ('WS', 'Samoa'),
    ('SM', 'San marino'),
    ('ST', 'Sao tome and principe'),
    ('SA', 'Saudi arabia'),
    ('SN', 'Senegal'),
    ('SC', 'Seychelles'),
    ('SL', 'Sierra leone'),
    ('SG', 'Singapore'),
    ('SK', 'Slovakia'),
    ('SI', 'Slovenia'),
    ('SB', 'Solomon islands'),
    ('SO', 'Somalia'),
    ('ZA', 'South africa'),
    ('GS', 'South georgia'),
    ('ES', 'Spain'),
    ('LK', 'Sri lanka'),
    ('SD', 'Sudan'),
    ('SR', 'Suriname'),
    ('SJ', 'Svalbard and jan mayen'),
    ('SZ', 'Swaziland'),
    ('SE', 'Sweden'),
    ('CH', 'Switzerland'),
    ('SY', 'Syrian arab republic'),
    ('TW', 'Taiwan, province of china'),
    ('TJ', 'Tajikistan'),
    ('TZ', 'Tanzania, united republic of'),
    ('TH', 'Thailand'),
    ('TG', 'Togo'),
    ('TK', 'Tokelau'),
    ('TO', 'Tonga'),
    ('TT', 'Trinidad and tobago'),
    ('TN', 'Tunisia'),
    ('TR', 'Turkey'),
    ('TM', 'Turkmenistan'),
    ('TC', 'Turks and caicos islands'),
    ('TV', 'Tuvalu'),
    ('UG', 'Uganda'),
    ('UA', 'Ukraine'),
    ('AE', 'United Arab Emirates'),
    ('GB', 'United Kingdom'),
    ('US', 'United States'),
    ('UM', 'United States minor islands'),
    ('UY', 'Uruguay'),
    ('UZ', 'Uzbekistan'),
    ('VU', 'Vanuatu'),
    ('VE', 'Venezuela'),
    ('VN', 'Viet nam'),
    ('VG', 'Virgin islands, british'),
    ('VI', 'Virgin islands, u.s.'),
    ('WF', 'Wallis and futuna'),
    ('EH', 'Western sahara'),
    ('YE', 'Yemen'),
    ('YU', 'Yugoslavia'),
    ('ZM', 'Zambia'),
    ('ZW', 'Zimbabwe');";
    
    
$sql_create_login_attempts = "
    CREATE TABLE IF NOT EXISTS `{$pre}login_attempts` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `ip_address` varbinary(16) NOT NULL,
    `login` varchar(100) NOT NULL,
    `time` int(11) unsigned DEFAULT NULL,
    PRIMARY KEY (`id`)
  ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";    
    
$sql_insert_login_attempts = "";


$sql_create_projects = "
    CREATE TABLE IF NOT EXISTS `{$pre}projects` (
        `project_id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(30) NOT NULL,
        `description` text NOT NULL,
        PRIMARY KEY (`project_id`)
      ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=2;";


$sql_insert_projects = "
    INSERT INTO `{$pre}projects` (`project_id`, `name`, `description`) VALUES
    (1, 'Your first project', '');";

$sql_create_users = "
    CREATE TABLE IF NOT EXISTS `{$pre}users` (
        `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
        `ip_address` varbinary(16) NOT NULL,
        `username` varchar(100) NOT NULL,
        `password` varchar(80) NOT NULL,
        `salt` varchar(40) DEFAULT NULL,
        `email` varchar(100) NOT NULL,
        `activation_code` varchar(40) DEFAULT NULL,
        `forgotten_password_code` varchar(40) DEFAULT NULL,
        `forgotten_password_time` int(11) unsigned DEFAULT NULL,
        `remember_code` varchar(40) DEFAULT NULL,
        `created_on` int(11) unsigned NOT NULL,
        `last_login` int(11) unsigned DEFAULT NULL,
        `active` tinyint(1) unsigned DEFAULT NULL,
        `first_name` varchar(50) DEFAULT NULL,
        `last_name` varchar(50) DEFAULT NULL,
        `company` varchar(100) DEFAULT NULL,
        `phone` varchar(20) DEFAULT NULL,
        `title` VARCHAR( 30 ) NULL ,
        `city` VARCHAR( 60 ) NULL ,
        `country_id` VARCHAR( 2 ) NULL ,
        `author_id` INT NOT NULL ,
        PRIMARY KEY (`id`)
      ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";


$sql_insert_users = "
        INSERT INTO `{$pre}users` (`id`, `ip_address`, `username`, `password`, `salt`, `email`, `activation_code`, `forgotten_password_code`, `forgotten_password_time`, `remember_code`, `created_on`, `last_login`, `active`, `first_name`, `last_name`, `company`, `phone`, `author_id`) VALUES
        (1, '\0\0', 'administrator', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'admin@admin.com', '', NULL, NULL, NULL, 1268889823, 1359044134, 1, 'Admin', 'istrator', 'ADMIN', '0', 1),
        (2, '\0\0', 'manager', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'manager@admin.com', '', NULL, NULL, NULL, 1268889823, 1349861218, 1, 'Man', 'ager', 'ADMIN', '0', 1),
        (3, '\0\0', 'developer', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'developer@admin.com', '', NULL, NULL, NULL, 1268889823, 1349861218, 1, 'Dev', 'eloper', 'ADMIN', '0', 1),
        (4, '\0\0', 'guest', '59beecdf7fc966e2f17fd8f65a4a9aeb09d4a3d4', '9462e8eee0', 'guest@admin.com', NULL, NULL, NULL, NULL, 1268889823, 1349952296, 1, 'Gu', 'est', 'ADMIN', '0', 1);
        ";
        
$sql_create_users_groups = "
    CREATE TABLE IF NOT EXISTS `{$pre}users_groups` (
      `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
      `user_id` mediumint(8) unsigned NOT NULL,
      `group_id` mediumint(8) unsigned NOT NULL,
      PRIMARY KEY (`id`)
    ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";


$sql_insert_users_groups = "    
        INSERT INTO `{$pre}users_groups` (`id`, `user_id`, `group_id`) VALUES
        (1, 1, 1),
        (3, 2, 2),
        (4, 3, 3),
        (5, 4, 4)";
        
$sql_create_project_status = "
    CREATE TABLE IF NOT EXISTS `{$pre}project_status` (
    `project_status_id` int(11) NOT NULL AUTO_INCREMENT,
    `project_id` int(11) NOT NULL,
    `status_date` datetime NOT NULL,
    `status_id` int(11) NOT NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`project_status_id`)
  ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";


$sql_insert_project_status = "
    INSERT INTO `{$pre}project_status` (`project_status_id`, `project_id`, `status_date`, `status_id`, `user_id`) VALUES
    (1, 1, '2013-01-24 00:00:00', 1, 1);
    ";

$sql_create_tasks = "
    CREATE TABLE IF NOT EXISTS `{$pre}tasks` (
        `task_id` int(11) NOT NULL AUTO_INCREMENT,
        `project_id` int(11) NOT NULL,
        `task_parent_id` int(11) NOT NULL,
        `priority` tinyint(4) NOT NULL,
        `context` varchar(100) NOT NULL,
        `title` varchar(250) NOT NULL,
        `description` text NOT NULL,
        `deadline_date` date NOT NULL,
        `expected_duration` smallint(6) NOT NULL,
        `total_duration` smallint(6) NOT NULL,
        `private` tinyint(1) NOT NULL,
        `user_id` int(11) NOT NULL,
        `author_id` int(11) NOT NULL,
        `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`task_id`)
      ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_insert_tasks = "
        INSERT INTO `{$pre}tasks` (`task_id`, `project_id`, `task_parent_id`, `priority`, `context`, `title`, `description`, `deadline_date`, `expected_duration`, `total_duration`, `private`, `user_id`,`author_id`) VALUES 
        (1, 1, 0, 3, '1', 'Congratulations! This is your first task', 'First of all, read the README.txt if you haven''t done it yet.\r\n\r\nLots of informations in there.', '9999-00-00', 0, 0, 0, 1, 1),
        (2, 1, 0, 5, '1', 'How to create a user', 'To create a new user, go to menu <i>manage > users</i> \r\n\r\nthen click on the <img src=\"skins/redfreak/images/b_new.png\" /> button.', '9999-00-00', 0, 0, 2, 1, 1),
        (3, 1, 0, 7, '4', 'Send some feedback', 'To send some feedback to the author, go to\r\n<a href=\"http://https://github.com/fromcouch/refreak/issues\" target=\"_blank\">https://github.com/fromcouch/refreak/issues</a>', '9999-00-00', 0, 0, 1, 1, 1);
";

$sql_create_tasks_comment = "
    CREATE TABLE IF NOT EXISTS `{$pre}task_comment` (
        `task_comment_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
        `task_id` int(10) unsigned NOT NULL DEFAULT '0',
        `user_id` int(10) unsigned NOT NULL DEFAULT '0',
        `post_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        `comment` text NOT NULL,
        `last_change_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
        PRIMARY KEY (`task_comment_id`),
        KEY `taskId` (`task_id`)
      ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_insert_tasks_comment = "";


$sql_create_tasks_status = "
    CREATE TABLE IF NOT EXISTS `{$pre}task_status` (
    `task_status_id` int(11) NOT NULL AUTO_INCREMENT,
    `task_id` int(11) NOT NULL,
    `status_date` datetime NOT NULL,
    `status` smallint(6) NOT NULL,
    `user_id` int(11) NOT NULL,
    PRIMARY KEY (`task_status_id`)
  ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";

$sql_insert_tasks_status = "
        INSERT INTO `{$pre}task_status` (`task_status_id`, `task_id`, `status_date`, `status`, `user_id`) VALUES 
        (1, 1, '2013-01-24 00:00:00', 0, 1),
        (2, 2, '2013-01-24 00:00:00', 0, 1),    
        (3, 3, '2013-01-24 00:00:00', 0, 1);    
";


$sql_create_user_project = "
    CREATE TABLE IF NOT EXISTS `{$pre}user_project` (
      `user_id` int(10) unsigned NOT NULL DEFAULT '0',
      `project_id` int(10) unsigned NOT NULL DEFAULT '0',
      `position` tinyint(3) unsigned NOT NULL DEFAULT '0',
      PRIMARY KEY (`user_id`,`project_id`)
    ) DEFAULT CHARSET=utf8;";
    
$sql_insert_user_project = "    
        INSERT INTO `{$pre}user_project` (`user_id`, `project_id`, `position`) VALUES
        (1, 1, 5);";

$sql_create_plugins = "
    CREATE TABLE IF NOT EXISTS `{$pre}plugins` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(50) NOT NULL,
        `directory` varchar(250) NOT NULL,
        `active` tinyint(1) NOT NULL,
	`class` varchar(250) DEFAULT NULL,
        PRIMARY KEY (`id`)
    ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
    
$sql_insert_plugins = "";

$sql_create_controllers = "
    CREATE TABLE IF NOT EXISTS `{$pre}controllers` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `controller_name` varchar(25) NOT NULL,
      PRIMARY KEY (`id`)
    ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;    
";
    
$sql_insert_controllers = "    
        INSERT INTO `{$pre}controllers` (`id`, `controller_name`) VALUES
        (1, 'tasks'),
        (2, 'projects'),
        (3, 'users'),
        (4, 'auth'),
        (5, 'plugin');
";

$sql_create_plugins_controllers = "
    CREATE TABLE IF NOT EXISTS `{$pre}plugin_controller` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `plugin_id` int(11) NOT NULL,
      `controller_id` int(11) NOT NULL,
      PRIMARY KEY (`id`)
    ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
    
$sql_insert_plugins_controllers = "";

$sql_create_plugin_data = "
    CREATE TABLE IF NOT EXISTS `{$pre}plugin_data` (
      `id` int(11) NOT NULL AUTO_INCREMENT,
      `plugin_id` int(11) NOT NULL,
      `data` text CHARACTER SET utf8 NOT NULL,
      PRIMARY KEY (`id`)
    ) DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
    
$sql_insert_plugin_data = "";