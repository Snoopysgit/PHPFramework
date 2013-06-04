<?php
ini_set("display_errors", TRUE);
ini_set('default_charset', 'UTF-8');
error_reporting(E_ALL);

header("Content-Type: text/html; charset=UTF-8");

require_once 'components/iajaxcomponent.interface.php';
require_once 'components/ihtmlconpoment.interface.php';

require_once 'components/htmlcomponent.aclass.php';
require_once 'components/ajaxComponent.aclass.php';

require_once 'components/htmlcontainer.class.php';
require_once 'components/htmlcontent.class.php';

require_once 'controlers/abstractcontroler.aclass.php';
require_once 'controlers/messagecontroler.class.php';
set_exception_handler(array("MessageControler", "handleException"));
set_error_handler(array("MessageControler", "handleError"));
require_once 'controlers/databasecontroler.class.php';
require_once 'controlers/sessioncontroler.class.php';
require_once 'controlers/logincontroler.class.php';
require_once 'controlers/navigationcontroler.class.php';
require_once 'controlers/contentControler.class.php';

require_once 'components/htmltext.class.php';
require_once 'components/htmllabel.class.php';
require_once 'components/htmlsessiontext.class.php';
require_once 'components/htmlbutton.class.php';
require_once 'components/htmlsubmitbutton.class.php';
require_once 'components/htmlform.class.php';
require_once 'components/htmlicon.class.php';
require_once 'components/htmlinput.class.php';
require_once 'components/htmlcheckbox.class.php';
require_once 'components/htmltitle.class.php';
require_once 'components/htmllist.class.php';
require_once 'components/htmllink.class.php';
require_once 'components/htmltable.class.php';
require_once 'components/htmldialog.class.php';

require_once 'orm/orm.aclass.php';
require_once 'orm/loginorm.class.php';
require_once 'orm/computerorm.class.php';
require_once 'orm/accessrightorm.class.php';
require_once 'orm/personaccessrightorm.class.php';
require_once 'orm/ormtableeditor.class.php';

require_once 'modules/loginbar.class.php';
require_once 'modules/menu.class.php';
require_once 'modules/employeelist.class.php';
require_once 'modules/employeeDataSheet.class.php';



?>