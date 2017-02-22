CREATE TABLE tblproductgroups (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  name TEXT NOT NULL,
  disabledgateways TEXT NOT NULL,
  hidden TEXT NOT NULL,
  order INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblproductconfigoptionssub (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  configid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  optionname TEXT NOT NULL,
  setup DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY(id)
);

CREATE TABLE tblproductconfigoptions (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  productid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  optionname TEXT NOT NULL,
  optiontype TEXT NOT NULL,
  order INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblproducts (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  type TEXT NOT NULL,
  gid INTEGER(10) NOT NULL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  hidden TEXT NOT NULL,
  showdomainoptions TEXT NOT NULL,
  welcomeemail INTEGER(1) NOT NULL,
  stockcontrol TEXT NOT NULL,
  qty INTEGER(1) NOT NULL,
  proratabilling TEXT NOT NULL,
  proratadate INTEGER(2) NOT NULL,
  proratachargenextmonth INTEGER(2) NOT NULL,
  paytype TEXT NOT NULL,
  msetupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  qsetupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  ssetupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  asetupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  bsetupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  monthly DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  quarterly DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  semiannual DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  annual DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  biennial DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  subdomain TEXT NOT NULL,
  autosetup TEXT NOT NULL,
  servertype TEXT NOT NULL,
  defaultserver INTEGER(1) NOT NULL,
  configoption1 TEXT NOT NULL,
  configoption2 TEXT NOT NULL,
  configoption3 TEXT NOT NULL,
  configoption4 TEXT NOT NULL,
  configoption5 TEXT NOT NULL,
  configoption6 TEXT NOT NULL,
  configoption7 TEXT NOT NULL,
  configoption8 TEXT NOT NULL,
  configoption9 TEXT NOT NULL,
  configoption10 TEXT NOT NULL,
  configoption11 TEXT NOT NULL,
  configoption12 TEXT NOT NULL,
  configoption13 TEXT NOT NULL,
  configoption14 TEXT NOT NULL,
  configoption15 TEXT NOT NULL,
  configoption16 TEXT NOT NULL,
  configoption17 TEXT NOT NULL,
  configoption18 TEXT NOT NULL,
  configoption19 TEXT NOT NULL,
  configoption20 TEXT NOT NULL,
  configoption21 TEXT NOT NULL,
  configoption22 TEXT NOT NULL,
  configoption23 TEXT NOT NULL,
  configoption24 TEXT NOT NULL,
  freedomain TEXT NOT NULL,
  freedomainpaymentterms TEXT NOT NULL,
  freedomaintlds TEXT NOT NULL,
  upgradepackages TEXT NOT NULL,
  configoptionsupgrade TEXT NOT NULL,
  billingcycleupgrade TEXT NOT NULL,
  tax INTEGER(1) NOT NULL,
  affiliateonetime TEXT NOT NULL,
  affiliatepaytype TEXT NOT NULL,
  affiliatepayamount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  downloads TEXT NOT NULL,
  order INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblreselleraccountsetup (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  packageid TEXT NOT NULL,
  resnumlimit TEXT NOT NULL,
  resnumlimitamt TEXT NOT NULL,
  rsnumlimitenabled TEXT NOT NULL,
  reslimit TEXT NOT NULL,
  resreslimit TEXT NOT NULL,
  rslimit-disk TEXT NOT NULL,
  rsolimit-disk TEXT NOT NULL,
  rslimit-bw TEXT NOT NULL,
  rsolimit-bw TEXT NOT NULL,
  acl-list-accts TEXT NOT NULL,
  acl-show-bandwidth TEXT NOT NULL,
  acl-create-acct TEXT NOT NULL,
  acl-edit-account TEXT NOT NULL,
  acl-suspend-acct TEXT NOT NULL,
  acl-kill-acct TEXT NOT NULL,
  acl-upgrade-account TEXT NOT NULL,
  acl-limit-bandwidth TEXT NOT NULL,
  acl-edit-mx TEXT NOT NULL,
  acl-frontpage TEXT NOT NULL,
  acl-mod-subdomains TEXT NOT NULL,
  acl-passwd TEXT NOT NULL,
  acl-quota TEXT NOT NULL,
  acl-res-cart TEXT NOT NULL,
  acl-ssl-gencrt TEXT NOT NULL,
  acl-ssl TEXT NOT NULL,
  acl-demo-setup TEXT NOT NULL,
  acl-rearrange-accts TEXT NOT NULL,
  acl-clustering TEXT NOT NULL,
  acl-create-dns TEXT NOT NULL,
  acl-edit-dns TEXT NOT NULL,
  acl-park-dns TEXT NOT NULL,
  acl-kill-dns TEXT NOT NULL,
  acl-add-pkg TEXT NOT NULL,
  acl-edit-pkg TEXT NOT NULL,
  acl-add-pkg-shell TEXT NOT NULL,
  acl-allow-unlimited-disk-pkgs TEXT NOT NULL,
  acl-allow-unlimited-pkgs TEXT NOT NULL,
  acl-add-pkg-ip TEXT NOT NULL,
  acl-allow-addoncreate TEXT NOT NULL,
  acl-allow-parkedcreate TEXT NOT NULL,
  acl-onlyselfandglobalpkgs TEXT NOT NULL,
  acl-disallow-shell TEXT NOT NULL,
  acl-all TEXT NOT NULL,
  acl-stats TEXT NOT NULL,
  acl-status TEXT NOT NULL,
  acl-restart TEXT NOT NULL,
  acl-mailcheck TEXT NOT NULL,
  acl-resftp TEXT NOT NULL,
  acl-news TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblregistrars (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  registrar TEXT NOT NULL,
  setting TEXT NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblpromotions (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  item TEXT NOT NULL,
  type TEXT NOT NULL,
  code TEXT NOT NULL,
  discount TEXT NOT NULL,
  value DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  expirationdate DATE NOT NULL,
  packages TEXT NOT NULL,
  addons TEXT NOT NULL,
  maxuses INTEGER(1) NOT NULL,
  uses INTEGER(1) NOT NULL,
  appliesto TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblpaymentgateways (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  gateway TEXT NOT NULL,
  type TEXT NOT NULL,
  setting TEXT NOT NULL,
  value TEXT NOT NULL,
  name TEXT NOT NULL,
  size INTEGER(1) NOT NULL,
  notes TEXT NOT NULL,
  description TEXT NOT NULL,
  order INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblinvoices (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  invoicenum TEXT NOT NULL,
  date DATE NOT NULL,
  duedate DATE NOT NULL,
  datepaid DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  subtotal DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  credit DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  tax DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  taxrate DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  status TEXT NOT NULL,
  randomstring TEXT NOT NULL,
  paymentmethod TEXT NOT NULL,
  notes TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblinvoiceitems (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  invoiceid TEXT NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  type TEXT NOT NULL,
  relid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  description TEXT NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  taxed INTEGER(1) NOT NULL,
  duedate DATE NOT NULL,
  paymentmethod TEXT NOT NULL,
  notes TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblhostingconfigoptions (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  relid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  configid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  optionid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  PRIMARY KEY(id)
);

CREATE TABLE tblknowledgebase (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  category TEXT NOT NULL,
  title TEXT NOT NULL,
  article TEXT NOT NULL,
  views INTEGER(1) NOT NULL,
  useful INTEGER(1) NOT NULL,
  votes INTEGER(1) NOT NULL,
  private TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblorders (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  ordernum BIGINT(10) NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  hostingid INTEGER(1) NOT NULL,
  domainids TEXT NOT NULL,
  addonids TEXT NOT NULL,
  upgradeids TEXT NOT NULL,
  domaintype TEXT NOT NULL,
  nameservers TEXT NOT NULL,
  transfersecret TEXT NOT NULL,
  promocode TEXT NOT NULL,
  promotype TEXT NOT NULL,
  promovalue TEXT NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  paymentmethod TEXT NOT NULL,
  invoiceid INTEGER(1) NOT NULL,
  status TEXT NOT NULL,
  ipaddress TEXT NOT NULL,
  fraudmodule TEXT NOT NULL,
  fraudoutput TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblnotes (
  id INTEGER(1) NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  adminid INTEGER(1) NOT NULL,
  created DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  modified DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  note TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblknowledgebasecats (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  parentid INTEGER(1) NOT NULL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  hidden TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbltickets (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  tid INTEGER(6) NOT NULL,
  did INTEGER(3) UNSIGNED ZEROFILL NOT NULL DEFAULT 000,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  c TEXT NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  title TEXT NOT NULL,
  message TEXT NOT NULL,
  status TEXT NOT NULL,
  urgency TEXT NOT NULL,
  admin TEXT NOT NULL,
  attachment TEXT NOT NULL,
  lastreply DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  flag INTEGER(1) NOT NULL,
  clientunread INTEGER(1) NOT NULL,
  adminunread INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketreplies (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  tid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  message TEXT NOT NULL,
  admin TEXT NOT NULL,
  attachment TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketpredefinedreplies (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  catid TEXT NOT NULL,
  name TEXT NOT NULL,
  reply TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketspamfilters (
  id INTEGER(1) NOT NULL,
  type ENUM('sender','subject','phrase') NOT NULL DEFAULT sender,
  content TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblwhoislog (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  domain TEXT NOT NULL,
  ip TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblupgrades (
  id INTEGER(1) NOT NULL,
  type TEXT NOT NULL,
  date DATE NOT NULL DEFAULT 0000-00-00,
  relid INTEGER(10) NOT NULL,
  originalvalue TEXT NOT NULL,
  newvalue TEXT NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  recurringchange DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  status ENUM('Pending','Completed') NOT NULL DEFAULT Pending,
  paid ENUM('Y','N') NOT NULL DEFAULT N,
  PRIMARY KEY(id)
);

CREATE TABLE tbltodolist (
  id INTEGER(1) NOT NULL,
  date DATE NOT NULL DEFAULT 0000-00-00,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  admin INTEGER(1) NOT NULL,
  status TEXT NOT NULL,
  duedate DATE NOT NULL DEFAULT 0000-00-00,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketpredefinedcats (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  parentid INTEGER(1) NOT NULL,
  name TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketbreaklines (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  breakline TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbltax (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  name TEXT NOT NULL,
  state TEXT NOT NULL,
  country TEXT NOT NULL,
  taxrate DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY(id)
);

CREATE TABLE tblservers (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  name TEXT NOT NULL,
  ipaddress TEXT NOT NULL,
  monthlycost DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  noc TEXT NOT NULL,
  statusaddress TEXT NOT NULL,
  primarynameserver TEXT NOT NULL,
  primarynameserverip TEXT NOT NULL,
  secondarynameserver TEXT NOT NULL,
  secondarynameserverip TEXT NOT NULL,
  maxaccounts INTEGER(1) NOT NULL,
  type TEXT NOT NULL,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  secure TEXT NOT NULL,
  active TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketdepartments (
  id INTEGER(3) UNSIGNED ZEROFILL NOT NULL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  email TEXT NOT NULL,
  hidden TEXT NOT NULL,
  order INTEGER(1) NOT NULL,
  host TEXT NOT NULL,
  port TEXT NOT NULL,
  login TEXT NOT NULL,
  password TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketnotes (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  admin TEXT NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  message TEXT NOT NULL,
  ticketid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketmaillog (
  id INTEGER(1) NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  to TEXT NOT NULL,
  name TEXT NOT NULL,
  email TEXT NOT NULL,
  subject TEXT NOT NULL,
  message TEXT NOT NULL,
  status TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblticketlog (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  tid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  action TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblbannedips (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  ip TEXT NOT NULL,
  reason TEXT NOT NULL,
  expires DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  PRIMARY KEY(id)
);

CREATE TABLE tblbannedemails (
  id INTEGER(1) NOT NULL,
  domain TEXT NOT NULL,
  count INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblannouncements (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  date DATE NOT NULL,
  title TEXT NOT NULL,
  announcement TEXT NOT NULL,
  published TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblbrowserlinks (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  name TEXT NOT NULL,
  url TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblclients (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  firstname TEXT NOT NULL,
  lastname TEXT NOT NULL,
  companyname TEXT NOT NULL,
  email TEXT NOT NULL,
  address1 TEXT NOT NULL,
  address2 TEXT NOT NULL,
  city TEXT NOT NULL,
  state TEXT NOT NULL,
  postcode TEXT NOT NULL,
  country TEXT NOT NULL,
  phonenumber TEXT NOT NULL,
  password TEXT NOT NULL,
  credit DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  taxexempt TEXT NOT NULL,
  datecreated DATE NOT NULL DEFAULT 0000-00-00,
  notes TEXT NOT NULL,
  cardtype VARCHAR(255) NOT NULL,
  cardnum BLOB NOT NULL,
  startdate BLOB NOT NULL,
  expdate BLOB NOT NULL,
  issuenumber BLOB NOT NULL,
  lastlogin DATETIME NOT NULL,
  ip TEXT NOT NULL,
  host TEXT NOT NULL,
  status TEXT NOT NULL,
  language TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblcancelrequests (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  relid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  reason TEXT NOT NULL,
  type TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblcalendar (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  title TEXT NOT NULL,
  desc TEXT NOT NULL,
  day TEXT NOT NULL,
  month TEXT NOT NULL,
  year TEXT NOT NULL,
  startt1 TEXT NOT NULL,
  startt2 TEXT NOT NULL,
  endt1 TEXT NOT NULL,
  endt2 TEXT NOT NULL,
  adminid INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblaffiliateshistory (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  affiliateid INTEGER(3) UNSIGNED ZEROFILL NOT NULL DEFAULT 000,
  date DATE NOT NULL DEFAULT 0000-00-00,
  affaccid INTEGER(1) NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY(id)
);

CREATE TABLE tbladdons (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  packages TEXT NOT NULL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  recurring DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  setupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  billingcycle TEXT NOT NULL,
  showorder TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblactivitylog (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  description TEXT NOT NULL,
  user TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblaccounts (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  gateway TEXT NOT NULL,
  date DATETIME NOT NULL,
  description TEXT NOT NULL,
  amountin DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  fees DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  amountout DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  transid TEXT NOT NULL,
  invoiceid INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbladminlog (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  adminusername TEXT NOT NULL,
  logintime DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  logouttime DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  ipaddress TEXT NOT NULL,
  sessionid TEXT NOT NULL,
  lastvisit DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  PRIMARY KEY(id)
);

CREATE TABLE tblaffiliatesaccounts (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  affiliateid TEXT NOT NULL,
  domain TEXT NOT NULL,
  package TEXT NOT NULL,
  billingcycle TEXT NOT NULL,
  regdate DATE NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  commission DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  lastpaid DATE NOT NULL DEFAULT 0000-00-00,
  relid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  PRIMARY KEY(id)
);

CREATE TABLE tblaffiliates (
  id INTEGER(3) UNSIGNED ZEROFILL NOT NULL,
  date DATE NOT NULL,
  clientid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  visitors INTEGER(1) NOT NULL,
  paytype TEXT NOT NULL,
  payamount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  balance DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  withdrawn DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY(id)
);

CREATE TABLE tbladmins (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  username TEXT NOT NULL,
  password VARCHAR(32) NOT NULL,
  firstname TEXT NOT NULL,
  lastname TEXT NOT NULL,
  email TEXT NOT NULL,
  userlevel TEXT NOT NULL,
  signature TEXT NOT NULL,
  notes TEXT NOT NULL,
  loginattempts INTEGER(1) NOT NULL,
  supportdepts TEXT NOT NULL,
  ticketnotifications CHAR(2) NOT NULL,
  ordernotifications CHAR(2) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblemailtemplates (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  type TEXT NOT NULL,
  name TEXT NOT NULL,
  subject TEXT NOT NULL,
  message TEXT NOT NULL,
  fromname TEXT NOT NULL,
  fromemail TEXT NOT NULL,
  disabled TEXT NOT NULL,
  custom TEXT NOT NULL,
  language TEXT NOT NULL,
  copyto TEXT NOT NULL,
  plaintext INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblemails (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  subject TEXT NOT NULL,
  message TEXT NOT NULL,
  date DATETIME NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbldownloads (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  type TEXT NOT NULL,
  category INTEGER(1) NOT NULL,
  title TEXT NOT NULL,
  description TEXT NOT NULL,
  location TEXT NOT NULL,
  downloads INTEGER(1) NOT NULL,
  clientsonly TEXT NOT NULL,
  productdownload TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblfraud (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  fraud TEXT NOT NULL,
  setting TEXT NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblhostingaddons (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  orderid INTEGER(1) NOT NULL,
  hostingid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  name TEXT NOT NULL,
  setupfee DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  recurring DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  billingcycle TEXT NOT NULL,
  status TEXT NOT NULL,
  regdate DATE NOT NULL DEFAULT 0000-00-00,
  nextduedate DATE NOT NULL,
  nextinvoicedate DATE NOT NULL DEFAULT 0000-00-00,
  paymentmethod TEXT NOT NULL,
  subscriptionid TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblhosting (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  orderid INTEGER(1) NOT NULL,
  regdate DATE NOT NULL DEFAULT 0000-00-00,
  domain TEXT NOT NULL,
  server TEXT NOT NULL,
  paymentmethod TEXT NOT NULL,
  firstpaymentamount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  billingcycle TEXT NOT NULL,
  nextduedate DATE NOT NULL,
  nextinvoicedate DATE NOT NULL,
  domainstatus TEXT NOT NULL,
  username TEXT NOT NULL,
  password TEXT NOT NULL,
  notes TEXT NOT NULL,
  subscriptionid TEXT NOT NULL,
  packageid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  overideautosuspend TEXT NOT NULL,
  dedicatedip TEXT NOT NULL,
  assignedips TEXT NOT NULL,
  rootpassword TEXT NOT NULL,
  ns1 TEXT NOT NULL,
  ns2 TEXT NOT NULL,
  diskusage INTEGER(10) NOT NULL,
  disklimit INTEGER(10) NOT NULL,
  bwusage INTEGER(10) NOT NULL,
  bwlimit INTEGER(10) NOT NULL,
  lastupdate DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  PRIMARY KEY(id)
);

CREATE TABLE tblgatewaylog (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  date DATETIME NOT NULL DEFAULT 0000-00-00 00:00:00,
  gateway TEXT NOT NULL,
  data TEXT NOT NULL,
  result TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbldownloadcats (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  parentid INTEGER(1) NOT NULL,
  name TEXT NOT NULL,
  description TEXT NOT NULL,
  hidden TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblcustomfields (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  type TEXT NOT NULL,
  relid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  num TEXT NOT NULL,
  fieldname TEXT NOT NULL,
  fieldtype TEXT NOT NULL,
  fieldoptions TEXT NOT NULL,
  adminonly TEXT NOT NULL,
  required TEXT NOT NULL,
  showorder TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tblcredit (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  clientid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  date DATE NOT NULL DEFAULT 0000-00-00,
  description TEXT NOT NULL,
  amount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY(id)
);

CREATE TABLE tblconfiguration (
  setting TEXT NOT NULL,
  value TEXT NOT NULL
);

CREATE TABLE tblcustomfieldsvalues (
  fieldid INTEGER(1) NOT NULL,
  relid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  value TEXT NOT NULL
);

CREATE TABLE tbldomainsadditionalfields (
  id INTEGER(1) NOT NULL,
  domainid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  name TEXT NOT NULL,
  value TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbldomains (
  id INTEGER(10) UNSIGNED ZEROFILL NOT NULL,
  userid INTEGER(10) UNSIGNED ZEROFILL NOT NULL DEFAULT 0000000000,
  orderid INTEGER(1) NOT NULL,
  registrationdate DATE NOT NULL DEFAULT 0000-00-00,
  domain TEXT NOT NULL,
  firstpaymentamount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  recurringamount DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  registrar TEXT NOT NULL,
  registrationperiod INTEGER(1) NOT NULL DEFAULT 1,
  expirydate DATE NOT NULL,
  subscriptionid TEXT NOT NULL,
  status TEXT NOT NULL,
  nextduedate DATE NOT NULL DEFAULT 0000-00-00,
  nextinvoicedate DATE NOT NULL DEFAULT 0000-00-00,
  additionalnotes TEXT NOT NULL,
  paymentmethod TEXT NOT NULL,
  urlforwarding TEXT NOT NULL,
  emailforwarding TEXT NOT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE tbldomainpricing (
  id INTEGER(1) UNSIGNED ZEROFILL NOT NULL,
  extension TEXT NOT NULL,
  registrationperiod INTEGER(1) NOT NULL,
  register DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  transfer DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  renew DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  autoreg TEXT NOT NULL,
  order INTEGER(1) NOT NULL,
  PRIMARY KEY(id)
);


