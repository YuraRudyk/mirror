#
# Table structure for table 'tx_glshop_domain_model_material'
#
CREATE TABLE tx_glshop_domain_model_material (

	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	pic text,
	materialoption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_materialoption'
#
CREATE TABLE tx_glshop_domain_model_materialoption (

	material int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	pic text,
	materialoptiontype int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_materialoptiontype'
#
CREATE TABLE tx_glshop_domain_model_materialoptiontype (

	materialoption int(11) unsigned DEFAULT '0' NOT NULL,

	size double(11,2) DEFAULT '0.00' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_conditions'
#
CREATE TABLE tx_glshop_domain_model_conditions (

	days int(11) DEFAULT '0' NOT NULL,
	reduction int(11) DEFAULT '0' NOT NULL,
	netto int(11) DEFAULT '0' NOT NULL,
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_fixing'
#
CREATE TABLE tx_glshop_domain_model_fixing (

	name varchar(255) DEFAULT '' NOT NULL,
	pic text,
	fixingoption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_fixingoption'
#
CREATE TABLE tx_glshop_domain_model_fixingoption (

	fixing int(11) unsigned DEFAULT '0' NOT NULL,

	article_nr varchar(255) DEFAULT '' NOT NULL,
	name varchar(255) DEFAULT '' NOT NULL,
	description text,
	projection double(11,2) DEFAULT '0.00' NOT NULL,
	from_size double(11,2) DEFAULT '0.00' NOT NULL,
	to_size double(11,2) DEFAULT '0.00' NOT NULL,
	drill_downside double(11,2) DEFAULT '0.00' NOT NULL,
	border_length double(11,2) DEFAULT '0.00' NOT NULL,
	position varchar(255) DEFAULT '' NOT NULL,
	diameter double(11,2) DEFAULT '0.00' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	pic text,

);

#
# Table structure for table 'tx_glshop_domain_model_borderediting'
#
CREATE TABLE tx_glshop_domain_model_borderediting (

	name varchar(255) DEFAULT '' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	pic text,
	bordereditingoption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_bordereditingoption'
#
CREATE TABLE tx_glshop_domain_model_bordereditingoption (

	borderediting int(11) unsigned DEFAULT '0' NOT NULL,

	form_size double(11,2) DEFAULT '0.00' NOT NULL,
	to_size double(11,2) DEFAULT '0.00' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_noticelist'
#
CREATE TABLE tx_glshop_domain_model_noticelist (

	notice_nr int(11) DEFAULT '0' NOT NULL,
	date int(11) DEFAULT '0' NOT NULL,
	article text,
	expire int(11) DEFAULT '0' NOT NULL,
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_cornerediting'
#
CREATE TABLE tx_glshop_domain_model_cornerediting (

	name varchar(255) DEFAULT '' NOT NULL,
	form varchar(255) DEFAULT '' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	pic text,
	cornereditingoption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_cornereditingoption'
#
CREATE TABLE tx_glshop_domain_model_cornereditingoption (

	cornerediting int(11) unsigned DEFAULT '0' NOT NULL,

	from_size double(11,2) DEFAULT '0.00' NOT NULL,
	to_size double(11,2) DEFAULT '0.00' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_bevel'
#
CREATE TABLE tx_glshop_domain_model_bevel (

	thread double(11,2) DEFAULT '0.00' NOT NULL,
	drill double(11,2) DEFAULT '0.00' NOT NULL,
	bevel double(11,2) DEFAULT '0.00' NOT NULL,
	depth double(11,2) DEFAULT '0.00' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_drill'
#
CREATE TABLE tx_glshop_domain_model_drill (

	name varchar(255) DEFAULT '' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	pic text,
	drilloption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_drilloption'
#
CREATE TABLE tx_glshop_domain_model_drilloption (

	drill int(11) unsigned DEFAULT '0' NOT NULL,

	from_size double(11,2) DEFAULT '0.00' NOT NULL,
	to_size double(11,2) DEFAULT '0.00' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_order'
#
CREATE TABLE tx_glshop_domain_model_order (

	date int(11) DEFAULT '0' NOT NULL,
	article text,
	comment text,
	formular text,
	user int(11) unsigned DEFAULT '0',
	confirmation int(11) unsigned DEFAULT '0' NOT NULL,
	production int(11) unsigned DEFAULT '0' NOT NULL,
	delivery int(11) unsigned DEFAULT '0' NOT NULL,
	invoice int(11) unsigned DEFAULT '0' NOT NULL,
	shippingaddress int(11) unsigned DEFAULT '0',
	orderstatus int(11) unsigned DEFAULT '0' NOT NULL,
	conditions int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_orderstatus'
#
CREATE TABLE tx_glshop_domain_model_orderstatus (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

	date int(11) DEFAULT '0' NOT NULL,
	orderstate int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_orderstate'
#
CREATE TABLE tx_glshop_domain_model_orderstate (

	name varchar(255) DEFAULT '' NOT NULL,
	value int(11) DEFAULT '0' NOT NULL,
	acr varchar(255) DEFAULT '' NOT NULL,
	prefix varchar(255) DEFAULT '' NOT NULL,
	label varchar(255) DEFAULT '' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_shippingaddress'
#
CREATE TABLE tx_glshop_domain_model_shippingaddress (

	company varchar(255) DEFAULT '' NOT NULL,
	person varchar(255) DEFAULT '' NOT NULL,
	street varchar(255) DEFAULT '' NOT NULL,
	zip varchar(255) DEFAULT '' NOT NULL,
	city varchar(255) DEFAULT '' NOT NULL,
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_confirmation'
#
CREATE TABLE tx_glshop_domain_model_confirmation (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

	file text,
	date int(11) DEFAULT '0' NOT NULL,
	send int(11) DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_production'
#
CREATE TABLE tx_glshop_domain_model_production (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

	file text,
	date int(11) DEFAULT '0' NOT NULL,
	send int(11) DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_delivery'
#
CREATE TABLE tx_glshop_domain_model_delivery (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

	file text,
	date int(11) DEFAULT '0' NOT NULL,
	send int(11) DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_invoice'
#
CREATE TABLE tx_glshop_domain_model_invoice (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

	file text,
	date int(11) DEFAULT '0' NOT NULL,
	send int(11) DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_cart'
#
CREATE TABLE tx_glshop_domain_model_cart (

	session_id varchar(255) DEFAULT '' NOT NULL,
	position int(11) DEFAULT '0' NOT NULL,
	article text,
	qty int(11) DEFAULT '0' NOT NULL,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	pic text,
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_request'
#
CREATE TABLE tx_glshop_domain_model_request (

	date int(11) DEFAULT '0' NOT NULL,
	title text,
	text text,
	files text,
	done int(11) DEFAULT '0' NOT NULL,
	user int(11) unsigned DEFAULT '0',

);

#
# Table structure for table 'tx_glshop_domain_model_shop'
#
CREATE TABLE tx_glshop_domain_model_shop (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	a_key text NOT NULL,
	a_value text NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_product'
#
CREATE TABLE tx_glshop_domain_model_product (

	name varchar(255) DEFAULT '' NOT NULL,
	pic text,
	productoption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_productoption'
#
CREATE TABLE tx_glshop_domain_model_productoption (

	product int(11) unsigned DEFAULT '0' NOT NULL,

	article_nr varchar(255) DEFAULT '' NOT NULL,
	description text,
	pic text,
	price double(11,2) DEFAULT '0.00' NOT NULL,
	from_size double(11,2) DEFAULT '0.00' NOT NULL,
	to_size double(11,2) DEFAULT '0.00' NOT NULL,
	width double(11,2) DEFAULT '0.00' NOT NULL,
	length double(11,2) DEFAULT '0.00' NOT NULL,
	height double(11,2) DEFAULT '0.00' NOT NULL,
	size double(11,2) DEFAULT '0.00' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_materialoption'
#
CREATE TABLE tx_glshop_domain_model_materialoption (

	material int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_materialoptiontype'
#
CREATE TABLE tx_glshop_domain_model_materialoptiontype (

	materialoption int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_fixingoption'
#
CREATE TABLE tx_glshop_domain_model_fixingoption (

	fixing int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_bordereditingoption'
#
CREATE TABLE tx_glshop_domain_model_bordereditingoption (

	borderediting int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_cornereditingoption'
#
CREATE TABLE tx_glshop_domain_model_cornereditingoption (

	cornerediting int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_drilloption'
#
CREATE TABLE tx_glshop_domain_model_drilloption (

	drill int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_confirmation'
#
CREATE TABLE tx_glshop_domain_model_confirmation (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_production'
#
CREATE TABLE tx_glshop_domain_model_production (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_delivery'
#
CREATE TABLE tx_glshop_domain_model_delivery (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_invoice'
#
CREATE TABLE tx_glshop_domain_model_invoice (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_orderstatus'
#
CREATE TABLE tx_glshop_domain_model_orderstatus (

	tx_order int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_productoption'
#
CREATE TABLE tx_glshop_domain_model_productoption (

	product int(11) unsigned DEFAULT '0' NOT NULL,

);

## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder

#
# Table structure for table 'tx_glshop_domain_model_price'
#
CREATE TABLE tx_glshop_domain_model_price (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	from_ek double(11,2) unsigned DEFAULT '0.00',
	to_ek double(11,2) unsigned DEFAULT '0.00',
	factor double(11,2) unsigned DEFAULT '0.00',
	fe_group int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'fe_users'
#
CREATE TABLE fe_users (
	payCondition varchar(255) DEFAULT '1' NOT NULL,
);

#
# Table structure for table 'tx_glshop_domain_model_rahmenprodukt'
#
CREATE TABLE tx_glshop_domain_model_rahmenprodukt (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	produktart int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	beschreibung text NOT NULL,
	bild varchar(255) DEFAULT '' NOT NULL,
	art_nr varchar(255) DEFAULT '' NOT NULL,
	frontscheibe int(11) DEFAULT '0' NOT NULL,
	preis double(11,2) DEFAULT '0.00' NOT NULL,
	variante int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_produktart'
#
CREATE TABLE tx_glshop_domain_model_produktart (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	beschreibung text NOT NULL,
	produkt int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_rahmenproduktvariante'
#
CREATE TABLE tx_glshop_domain_model_rahmenproduktvariante (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	rahmenprodukt int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	beschreibung text NOT NULL,
	bild varchar(255) DEFAULT '' NOT NULL,
	art_nr varchar(255) DEFAULT '' NOT NULL,
	laenge double(11,2) DEFAULT '0.00' NOT NULL,
	dicke double(11,2) DEFAULT '0.00' NOT NULL,
	sonder int(11) DEFAULT '0' NOT NULL,
	sicherheit int(11) DEFAULT '0' NOT NULL,
	preis double(11,2) DEFAULT '0.00' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_rahmenproduktvariante'
#
CREATE TABLE tx_glshop_domain_model_rahmenproduktvariante (

	rahmenprodukt  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_rahmenprodukt'
#
CREATE TABLE tx_glshop_domain_model_rahmenprodukt (

	produktart  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_domain_model_rechnungsbuch'
#
CREATE TABLE tx_glshop_domain_model_rechnungsbuch (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	status int(11) unsigned DEFAULT '0',
	bestellung int(11) unsigned DEFAULT '0',
	termin int(11) DEFAULT '0' NOT NULL,
	netto double(11,2) DEFAULT '0.00' NOT NULL,
	steuer double(11,2) DEFAULT '0.00' NOT NULL,
	brutto double(11,2) DEFAULT '0.00' NOT NULL,
	eingang_zahlung int(11) DEFAULT '0' NOT NULL,
	abschluss tinyint(4) unsigned DEFAULT '0' NOT NULL,
	arbeitszeit double(11,2) DEFAULT '0.00' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_status'
#
CREATE TABLE tx_glshop_domain_model_status (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	farbe varchar(255) DEFAULT '' NOT NULL,
	bereich int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_bereich'
#
CREATE TABLE tx_glshop_domain_model_bereich (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_glshop_domain_model_kategorie'
#
CREATE TABLE tx_glshop_domain_model_kategorie (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	bild int(11) unsigned NOT NULL default '0',
	produkte int(11) unsigned DEFAULT '0' NOT NULL,
	shopbereiche int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_produkt'
#
CREATE TABLE tx_glshop_domain_model_produkt (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	kategorie int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	anzeige_name varchar(255) DEFAULT '' NOT NULL,
	bild int(11) unsigned NOT NULL default '0',
	einzel_verkauf tinyint(1) unsigned DEFAULT '0' NOT NULL,
	eigenschaften int(11) unsigned DEFAULT '0' NOT NULL,
	produktvarianten int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_produktvarianten'
#
CREATE TABLE tx_glshop_domain_model_produktvarianten (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	produkt int(11) unsigned DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	anzeige_name varchar(255) DEFAULT '' NOT NULL,
	bilder int(11) unsigned NOT NULL default '0',
	eingeschaftenset int(11) unsigned DEFAULT '0' NOT NULL,
	bearbeitungen int(11) unsigned DEFAULT '0' NOT NULL,
	ausschluss_kategorie int(11) unsigned DEFAULT '0' NOT NULL,
	ausschluss_produkt int(11) unsigned DEFAULT '0' NOT NULL,
	ausschluss_variante int(11) unsigned DEFAULT '0' NOT NULL,
	zubehoer int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_eigenschaften'
#
CREATE TABLE tx_glshop_domain_model_eigenschaften (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	anzeige_name varchar(255) DEFAULT '' NOT NULL,
	einheit varchar(255) DEFAULT '' NOT NULL,
	datentyp int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_eigenschaftenset'
#
CREATE TABLE tx_glshop_domain_model_eigenschaftenset (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	produktvarianten int(11) unsigned DEFAULT '0' NOT NULL,
	produktsets int(11) unsigned DEFAULT '0' NOT NULL,

	wert varchar(255) DEFAULT '' NOT NULL,
	eigenschaften int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_produktbeziehungen'
#
CREATE TABLE tx_glshop_domain_model_produktbeziehungen (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	min_anzahl int(11) DEFAULT '0' NOT NULL,
	bestellung_von int(11) unsigned DEFAULT '0',
	bestellung_mit int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_shopbereiche'
#
CREATE TABLE tx_glshop_domain_model_shopbereiche (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	anzeige_name varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_produktsets'
#
CREATE TABLE tx_glshop_domain_model_produktsets (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	anzeige_name varchar(255) DEFAULT '' NOT NULL,
	produkte int(11) unsigned DEFAULT '0' NOT NULL,
	eigenschaften int(11) unsigned DEFAULT '0' NOT NULL,
	eigenschaftenset int(11) unsigned DEFAULT '0' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_datentypen'
#
CREATE TABLE tx_glshop_domain_model_datentypen (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	cast varchar(255) DEFAULT '' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_bearbeitungen'
#
CREATE TABLE tx_glshop_domain_model_bearbeitungen (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	taetigkeit varchar(255) DEFAULT '' NOT NULL,
	haengt_ab_von varchar(255) DEFAULT '' NOT NULL,
	zeitvorgabe double(11,2) DEFAULT '0.00' NOT NULL,
	einheit varchar(255) DEFAULT '' NOT NULL,
	min_berechnung double(11,2) DEFAULT '0.00' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_produkt'
#
CREATE TABLE tx_glshop_domain_model_produkt (

	kategorie  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_kategorie_shopbereiche_mm'
#
CREATE TABLE tx_glshop_kategorie_shopbereiche_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_domain_model_produktvarianten'
#
CREATE TABLE tx_glshop_domain_model_produktvarianten (

	produkt  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_produkt_eigenschaften_mm'
#
CREATE TABLE tx_glshop_produkt_eigenschaften_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_domain_model_eigenschaftenset'
#
CREATE TABLE tx_glshop_domain_model_eigenschaftenset (

	produktvarianten  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_produktvarianten_bearbeitungen_mm'
#
CREATE TABLE tx_glshop_produktvarianten_bearbeitungen_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_produktvarianten_kategorie_mm'
#
CREATE TABLE tx_glshop_produktvarianten_kategorie_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_produktvarianten_produkt_mm'
#
CREATE TABLE tx_glshop_produktvarianten_produkt_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_produktvarianten_produktvarianten_mm'
#
CREATE TABLE tx_glshop_produktvarianten_produktvarianten_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_produktvarianten_zubehoer_produktvarianten_mm'
#
CREATE TABLE tx_glshop_produktvarianten_zubehoer_produktvarianten_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_domain_model_eigenschaftenset'
#
CREATE TABLE tx_glshop_domain_model_eigenschaftenset (

	produktsets  int(11) unsigned DEFAULT '0' NOT NULL,

);

#
# Table structure for table 'tx_glshop_produktsets_produkt_mm'
#
CREATE TABLE tx_glshop_produktsets_produkt_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_produktsets_eigenschaften_mm'
#
CREATE TABLE tx_glshop_produktsets_eigenschaften_mm (
	uid_local int(11) unsigned DEFAULT '0' NOT NULL,
	uid_foreign int(11) unsigned DEFAULT '0' NOT NULL,
	sorting int(11) unsigned DEFAULT '0' NOT NULL,
	sorting_foreign int(11) unsigned DEFAULT '0' NOT NULL,

	KEY uid_local (uid_local),
	KEY uid_foreign (uid_foreign)
);

#
# Table structure for table 'tx_glshop_domain_model_gutschein'
#
CREATE TABLE tx_glshop_domain_model_gutschein (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	code varchar(255) DEFAULT '' NOT NULL,
	wert double(11,2) DEFAULT '0.00' NOT NULL,
	prozent tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ab int(11) DEFAULT '0' NOT NULL,
	bis int(11) DEFAULT '0' NOT NULL,
	anzahl int(11) DEFAULT '0' NOT NULL,
	unbegrenzt tinyint(1) unsigned DEFAULT '0' NOT NULL,
	abgelaufen tinyint(1) unsigned DEFAULT '0' NOT NULL,
	ab_wert double(11,2) DEFAULT '0.00' NOT NULL,
	kunde_beliebig tinyint(1) unsigned DEFAULT '0' NOT NULL,
	kunde_beliebig_fest tinyint(1) unsigned DEFAULT '0' NOT NULL,
	rest_wert tinyint(1) unsigned DEFAULT '0' NOT NULL,
	user int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_gutscheinusage'
#
CREATE TABLE tx_glshop_domain_model_gutscheinusage (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	datum int(11) DEFAULT '0' NOT NULL,
	wert double(11,2) DEFAULT '0.00' NOT NULL,
	gutschein int(11) unsigned DEFAULT '0',
	user int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);


#
# Table structure for table 'tx_glshop_domain_model_partnerlisten'
#
CREATE TABLE tx_glshop_domain_model_partnerlisten (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	name varchar(255) DEFAULT '' NOT NULL,
	rabatt double(11,2) DEFAULT '0.00' NOT NULL,

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);

#
# Table structure for table 'tx_glshop_domain_model_partner'
#
CREATE TABLE tx_glshop_domain_model_partner (

	uid int(11) NOT NULL auto_increment,
	pid int(11) DEFAULT '0' NOT NULL,

	firmenname varchar(255) DEFAULT '' NOT NULL,
	partnernummer varchar(255) DEFAULT '' NOT NULL,
	bestaetigt tinyint(1) unsigned DEFAULT '0' NOT NULL,
	partnerliste int(11) unsigned DEFAULT '0',
	kunde int(11) unsigned DEFAULT '0',

	tstamp int(11) unsigned DEFAULT '0' NOT NULL,
	crdate int(11) unsigned DEFAULT '0' NOT NULL,
	cruser_id int(11) unsigned DEFAULT '0' NOT NULL,
	deleted tinyint(4) unsigned DEFAULT '0' NOT NULL,
	hidden tinyint(4) unsigned DEFAULT '0' NOT NULL,
	starttime int(11) unsigned DEFAULT '0' NOT NULL,
	endtime int(11) unsigned DEFAULT '0' NOT NULL,

	t3ver_oid int(11) DEFAULT '0' NOT NULL,
	t3ver_id int(11) DEFAULT '0' NOT NULL,
	t3ver_wsid int(11) DEFAULT '0' NOT NULL,
	t3ver_label varchar(255) DEFAULT '' NOT NULL,
	t3ver_state tinyint(4) DEFAULT '0' NOT NULL,
	t3ver_stage int(11) DEFAULT '0' NOT NULL,
	t3ver_count int(11) DEFAULT '0' NOT NULL,
	t3ver_tstamp int(11) DEFAULT '0' NOT NULL,
	t3ver_move_id int(11) DEFAULT '0' NOT NULL,

	sys_language_uid int(11) DEFAULT '0' NOT NULL,
	l10n_parent int(11) DEFAULT '0' NOT NULL,
	l10n_diffsource mediumblob,

	PRIMARY KEY (uid),
	KEY parent (pid),
	KEY t3ver_oid (t3ver_oid,t3ver_wsid),
 KEY language (l10n_parent,sys_language_uid)

);