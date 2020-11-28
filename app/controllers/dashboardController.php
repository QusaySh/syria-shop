<?php
namespace syriashop\controllers;
use syriashop\modals\UsersModals;
use syriashop\modals\ItemsModals;
use syriashop\modals\cateogriesModals;
use syriashop\modals\LocationModals;
use syriashop\modals\CityModals;
use syriashop\modals\ReportsItemsModals;
use \syriashop\lib\Languages;

class DashboardController extends AbstractController {
    use \syriashop\lib\Redirect; // استخدام تريت اعادة التحويل
    use \syriashop\lib\FilterInput;
    use \syriashop\lib\Messages;
    
    public function defaultAction(){
        $users = new UsersModals();
        $ads = new ItemsModals();
        // عدد السجلات في كل جدول
        $this->_data['countTable'] = array (
            "countUsers" => $users->rowCount("users"),
            "countAds" => $users->rowCount("items"),
            "countCat" => $users->rowCount("categories"),
            "countCountry" => $users->rowCount("location_country")
        );
        
        $limit = 5; // عدد السجلات المراد جلبها
        // جلب آخر خمس مستخدمين
        $sqlUsers = $users->sql("username, id", "users", "ORDER BY id DESC LIMIT $limit", null, "all");
        $this->_data["lastUsers"] = $sqlUsers;
        // جلب آخر خمس اعلانات
        $sqlAds = $users->sql("users.username, items.item_name, items.item_description, users.user_type, users.my_img",
                "users, items", "WHERE users.id = items.user_id ORDER BY items.item_id DESC LIMIT $limit", null, "all");
        $this->_data["lastAds"] = $sqlAds;  
        
        $users = new UsersModals();
        $items = new ItemsModals();
        // احصائيات الاعلانات
        $statistc = $items->sql("item_add_date, count(*) as countItem",
                "items", "where item_add_date >= DATE_SUB(NOW(), INTERVAL 1 week) GROUP BY day(item_add_date) ", "", "all");
        $statistcItems = "";
        if ( !empty($statistc) ) {
            foreach ($statistc as $st ) {
                $statistcItems .= "{year: '" . date("Y-m-d", strtotime($st->item_add_date)) . "', value: {$st->countItem}}, ";
            }
        } else {
            $statistc = 0;
        }
        $statistcItems = substr($statistcItems, 0, -2);
        $this->_data["statistcItems"] = $statistcItems;
        // احصائيات المستحدمين
        $statistc = $items->sql("date_of_registration, count(*) as countUser",
                "users", "where date_of_registration >= DATE_SUB(NOW(), INTERVAL 1 month) GROUP BY day(date_of_registration) ", "", "all");
        $statistcUsers = "";
        if ( !empty($statistc) ) {
            foreach ($statistc as $st ) {
                $statistcUsers .= "{year: '" . date("Y-m-d", strtotime($st->date_of_registration)) . "', value: {$st->countUser}}, ";
            }
        } else {
            $statistc = 0;
        }
        $statistcItems = substr($statistcUsers, 0, -2);
        $this->_data["statistcUsers"] = $statistcUsers;
        $this->_view();
    }
    //العملاء
    public function usersAction(){
        $users = new UsersModals();
        
        // تعدد الصفات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_TABLE; /// كم سجل بدي يظهر
        $ads = new ItemsModals();
        $record_count = $ads->rowCount("users"); // عدد السجلات
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]['start']  = $start;
        $this->_data["thePage"]['end']  = $end;
        
        $sqlUsers = $users->sql("id, username, email, type_user, block", "users", "LIMIT $start, $end", null, "all");
        $this->_data["allUsers"] = !empty($sqlUsers) ? $sqlUsers : $this->message("blue", \syriashop\lib\Languages::lang("dashboardNotFoundUser", $GLOBALS["lang"]));
        
        $this->_view();
    }
    public function deleteUserAction(){
        if ( isset($_POST['delete']) ) {
            $users = new UsersModals();
            $items = new ItemsModals();
            $cat   = new cateogriesModals();
            
            $idUser = $this->filterInt($_POST["idUser"]);
            
            $users->id = $idUser;
            $getInfoUser = $users->getByKey();
            
            $dir = LOGO_PATH . DS . "items_media"; // تحديد مسار المجلد
            
            $scanDir = scandir($dir); // قراءة المجلد
            $getMedia = $items->sql("item_media", "items","WHERE user_id = $idUser", null, "all");
            if ( $users->delete(" WHERE id = $idUser") && $items->delete(" WHERE user_id = $idUser") ) {
                if ( !empty($getMedia) ) {
                    foreach ( $getMedia as $media ) {
                        $m = explode(",", $media->item_media);
                        foreach ( $m as $img ) { // الدخول في مصفوفة الصور
                            foreach ( $scanDir as $d ) { // الدخول في المجلد
                                if ( is_file($dir . "/" . $d) ) { // التأكد من انه ملف
                                    if ( $d == $img ) { // مقارنة مع ملف الموجود في المجلد مع صورة المرفق
                                        unlink($dir . "/" . $d);
                                    }
                                }
                            }
                        }
                    }
                }
                $dirPictureProfile = LOGO_PATH . DS . "/Picture Profile" . DS .
                        $getInfoUser->username .  DS . $getInfoUser->my_img;
                if ( is_file($dirPictureProfile) ) { // حذف الصورة الشخصية
                    unlink($dirPictureProfile);
                }
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageDeleteUser", $GLOBALS["lang"]));
            } else {
                $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    public function blockUserAction(){
        if ( isset($_POST["block"]) ) {
            $user = new UsersModals();
            $id = $this->filterInt($_POST["idUser"]);
            $getTypeUser = $user->getByColumn("id", $id);
            if ( $getTypeUser->block == 0 ) {
                if ( $user->updateSingle("block = 1", "id = $id") ) {
                    $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageBlock", $GLOBALS["lang"]));
                    $result["icon"] = "check";
                } else {
                    $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
                }
            } else {
                if ( $user->updateSingle("block = 0", "id = $id") ) {
                    $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageUnBlock", $GLOBALS["lang"]));
                    $result["icon"] = "block";
                } else {
                    $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
                }
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    public function typeUserAction(){
            if ( isset($_POST["typeUser"]) ) {
                $user = new UsersModals();
                $id = $this->filterInt($_POST["idUser"]);
                $getTypeUser = $user->getByColumn("id", $id);
                if ( $getTypeUser->type_user == "guest" ) {
                    if ( $user->updateSingle("type_user = 'admin'", "id = $id") ) {
                        $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessagePermissions", $GLOBALS["lang"]));
                        $result["icon"] = "person";
                    } else {
                        $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
                    }
                } else {
                    if ( $user->updateSingle("type_user = 'guest'", "id = $id") ) {
                        $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageUnPermissions", $GLOBALS["lang"]));
                        $result["icon"] = "security";
                    } else {
                        $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
                    }
                }
                header("content-type: application/json");
                echo json_encode($result);
            }
        }
    // المنتجات
    public function itemsAction(){
        $users = new UsersModals();
        
        $by = isset($_GET["by"]) ? $_GET["by"] : "all"; // حسب العمود في قاعدة البيانات
        $sort = isset($_GET["sort"]) && in_array($_GET["sort"], array("DSEC", "ASC")) ? $_GET["sort"] : "DESC"; // نوع الترتيب
        
        
        // تعدد الصفات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_TABLE; /// كم سجل بدي يظهر
        $ads = new ItemsModals();
        $record_count = $ads->rowCount("items"); // عدد السجلات
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]['start']  = $start;
        $this->_data["thePage"]['end']  = $end;
        
        if ( $by == "item_name" ) { // في حال الاختيار حسب البلد
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY $by $sort LIMIT $start, $end", null, "all");
        } else if ( $by == "item_description" ) {
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY $by $sort LIMIT $start, $end", null, "all");
        } else if ( $by == "item_add_date" ) {
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY $by $sort LIMIT $start, $end", null, "all");
        } else if ( $by == "item_country" ) {
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY $by $sort LIMIT $start, $end", null, "all");
        } else if ( $by == "item_location" ) {
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY $by $sort LIMIT $start, $end", null, "all");
        } else if ( $by == "username" ) {
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY $by $sort LIMIT $start, $end", null, "all");
        } else { // في اختيار جميع البيانات
            $sqlItems = $users->sql("items.*, users.username", "items, users", "WHERE items.user_id = users.id ORDER BY item_id DESC LIMIT $start, $end", null, "all");
        }
        $this->_data["allItems"] = !empty($sqlItems) ? $sqlItems : $this->message("blue", \syriashop\lib\Languages::lang("dashboardNotFoundAds", $GLOBALS["lang"]));
        
        $this->_view();
    }
    //// حذف الاعلان في newAds
    // البلد
    public function countryAction(){
        $country = new LocationModals();
        
        // تعدد الصفات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_TABLE; /// كم سجل بدي يظهر
        $record_count = $country->rowCount("location_country"); // عدد السجلات
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]['start']  = $start;
        $this->_data["thePage"]['end']  = $end;
        
        $sqlCountry = $country->sql("*", "location_country", "ORDER BY location_name ASC LIMIT $start, $end", null, "all");
        $this->_data["allCountry"] = !empty($sqlCountry) ? $sqlCountry : $this->message("blue", \syriashop\lib\Languages::lang("dashboardNotFoundCountry", $GLOBALS["lang"]));
        
        $this->_view();
    }
    public function addCountryAction(){
        if ( isset($_POST["addCountry"]) ) {
            $country = new LocationModals;
            $country->location_name = $this->filterStr($_POST["country_name"]);
            $country->location_number = $this->filterStr($_POST["country_key"]);
            if ( $country->checkInput() ) {
                $result["status"] = "error";
                $result["message"] =  $country->showMessages();
            } else {
                $newNameFile = uniqid() . "." . pathinfo($_FILES["uploadCountry"]["name"], PATHINFO_EXTENSION);
                if ( move_uploaded_file($_FILES["uploadCountry"]["tmp_name"], LOGO_PATH . DS . "images" . DS . "icons_country" . DS . $newNameFile) ) {
                    $country->location_icon = $newNameFile;
                    $country->insert();
                }
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageAddCountry", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function editCountryAction(){
        if ( isset($_POST["editCountry"]) ) {
            $country = new LocationModals;
            $country->location_name = $this->filterStr($_POST["country_name"]);
            $country->location_number = $this->filterStr($_POST["country_key"]);
            $country->location_country_id = $_POST["countryId"];
            $dirIcon = LOGO_PATH . DS . "images" . DS . "icons_country"; // مسار الايقونات
            // جلب الايقون القديمة
            $countryOld = $country->getByColumn("location_country_id", $_POST["countryId"]);
            if ( $country->checkInput("edit") ) {
                $result["status"] = "error";
                $result["message"] =  $country->showMessages();
            } else {
                if ( !empty($_FILES["uploadCountry"]) ) {
                    $newNameFile = uniqid() . "." . pathinfo($_FILES["uploadCountry"]["name"], PATHINFO_EXTENSION);
                    // خذف الايقونة القديمة
                    if ( file_exists($dirIcon . DS . $countryOld->location_icon) ) {
                        unlink($dirIcon . DS . $countryOld->location_icon);
                    }
                    if ( move_uploaded_file($_FILES["uploadCountry"]["tmp_name"], $dirIcon . DS . $newNameFile) ) {
                        $country->location_icon = $newNameFile;
                    }
                } else { // في حال عدم اختيار ايقونة
                    $country->location_icon = $countryOld->location_icon;
                }
                $country->updateSingle("location_name = '{$country->location_name}', location_number = '{$country->location_number}', location_icon = '{$country->location_icon}'", "location_country_id = {$country->location_country_id}");
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageEditCountry", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function deleteCountryAction(){
        if ( isset($_POST["delete"]) ) {
            $country = new LocationModals;
            $id = $this->filterInt($_POST["id"]);
            $country->location_country_id = $id;
            $getIcon = $country->getByKey();
            if ( $country->delete(" where location_country_id = $id") ) {
                $dirIcon = LOGO_PATH . DS . "images" . DS . "icons_country" . DS . $getIcon->location_icon;
                if ( is_file($dirIcon) ) {
                    unlink($dirIcon);
                }
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageDeleteCountry", $GLOBALS["lang"]));
            } else {
                $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function getCountryByIdAction(){
        if ( $_POST["getCountry"] ) {
            $id = $this->filterInt($_POST["id"]);
            $country = new LocationModals;
            $getCountry = $country->getByColumn("location_country_id", $id);
            if ( !empty($getCountry) ) {
                $result["status"] = "success";
                $result["message"] = $getCountry;
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageCountryNotExists", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    // المدن
    public function cityAction(){
        $city = new CityModals();
        $country = new LocationModals;
        
        $by = isset($_GET["by"]) ? $_GET["by"] : "all"; // حسب العمود في قاعدة البيانات
        $sort = isset($_GET["sort"]) && in_array($_GET["sort"], array("DSEC", "ASC")) ? $_GET["sort"] : "DESC"; // نوع الترتيب
        
        // تعدد الصفات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_TABLE; /// كم سجل بدي يظهر
        $record_count = $city->rowCount("location_city"); // عدد السجلات
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]['start']  = $start;
        $this->_data["thePage"]['end']  = $end;
        if ( $by == "location_country_name" ) {
            $sqlCity = $city->sql("location_city.*, location_country.location_name as countryName",
                    "location_city, location_country", "where location_city.location_country_id = location_country.location_country_id ORDER BY location_country.location_name $sort LIMIT $start, $end", null, "all");
        } else if ( $by == "location_city_name" ) {
            $sqlCity = $city->sql("location_city.*, location_country.location_name as countryName",
                    "location_city, location_country", "where location_city.location_country_id = location_country.location_country_id ORDER BY location_city.location_name $sort LIMIT $start, $end", null, "all");
        } else {
            $sqlCity = $city->sql("location_city.*, location_country.location_name as countryName",
                    "location_city, location_country", "where location_city.location_country_id = location_country.location_country_id ORDER BY location_city.location_name ASC LIMIT $start, $end", null, "all");
        }
        
        $this->_data["allCity"] = !empty($sqlCity) ? $sqlCity : $this->message("blue", \syriashop\lib\Languages::lang("dashboardNotFoundCountry", $GLOBALS["lang"]));
        
        $getAllCountry = $country->getAll();
        $this->_data["getAllCountry"] = $getAllCountry;
        
        $this->_view();
    }
    public function addCityAction(){
        if ( isset($_POST["addCity"]) ) {
            $city = new CityModals();
            $city->location_name = $this->filterStr($_POST["city_name"]);
            $city->location_country_id = $this->filterInt($_POST["country_name"]);
            if ( $city->checkInput() ) {
                $result["status"] = "error";
                $result["message"] =  $city->showMessages();
            } else {
                $city->insert();
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageAddCity", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function getCityByIdAction(){
        if ( $_POST["getCity"] ) {
            $id = $this->filterInt($_POST["id"]);
            $city = new CityModals();
            $getCity = $city->sql("ci.*, co.location_name as country_name", "location_country as co, location_city as ci",
                    "where ci.location_country_id = co.location_country_id AND ci.location_city_id = $id");
            if ( !empty($getCity) ) {
                $result["status"] = "success";
                $result["message"] = $getCity;
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageCountryNotExists", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    public function editCityAction(){
        if ( isset($_POST["editCity"]) ) {
            $city = new CityModals();
            $city->location_name = $this->filterStr($_POST["city_name"]);
            $city->location_country_id = $this->filterInt($_POST["country_name"]);
            $city->location_city_id = $_POST["cityId"];
            if ( $city->checkInput("edit") ) {
                $result["status"] = "error";
                $result["message"] =  $city->showMessages();
            } else {
                $city->update();
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageEditCity", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function deleteCityAction(){
        if ( isset($_POST["delete"]) ) {
            $city = new CityModals();
            $id = $this->filterInt($_POST["id"]);
            $city->delete(" where location_city_id = $id");
            $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageDeleteCity", $GLOBALS["lang"]));
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    // الاقسام
    public function categoriesAction(){
        $cat = new cateogriesModals();
        
        // تعدد الصفات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_TABLE; /// كم سجل بدي يظهر
        $record_count = $cat->rowCount("categories"); // عدد السجلات
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]['start']  = $start;
        $this->_data["thePage"]['end']  = $end;
        
        $sqlCat = $cat->sql("*", "categories", "ORDER BY categorie_parent, categorie_id ASC LIMIT $start, $end", null, "all");
        $this->_data["allCat"] = !empty($sqlCat) ? $sqlCat : $this->message("blue", \syriashop\lib\Languages::lang("dashboardNotFoundCountry", $GLOBALS["lang"]));
        
        // جلب جميع الاقسام
        $getAllCat = $cat->getAll();
        $this->_data["getAllCat"] = $getAllCat;
        
        $this->_view();
    }
    public function addCategoriesAction(){
        if ( isset($_POST["addCat"]) ) {
            $cat = new cateogriesModals;
            $cat->categorie_name = $this->filterStr($_POST["categorie_name"]);
            $cat->categorie_parent = $this->filterStr($_POST["categorie_parent"]);
            if ( $cat->checkInput() ) {
                $result["status"] = "error";
                $result["message"] =  $cat->showMessages();
            } else {
                if ( !empty($_FILES["uploadIconCat"]["name"]) ) {
                    $newNameFile = uniqid() . "." . pathinfo($_FILES["uploadIconCat"]["name"], PATHINFO_EXTENSION);
                    if ( move_uploaded_file($_FILES["uploadIconCat"]["tmp_name"], LOGO_PATH . DS . "images" . DS . "icons_cat" . DS . $newNameFile) ) {
                        $cat->categorie_icon = $newNameFile;
                    }
                }
                $cat->insert();
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageAddCat", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function editCategoriesAction(){
        if ( isset($_POST["editCat"]) ) {
            $cat = new cateogriesModals;
            $cat->categorie_name = $this->filterStr($_POST["categorie_name"]);
            $cat->categorie_parent = $this->filterStr($_POST["categorie_parent"]);
            $cat->categorie_id = $_POST["catId"];
            $dirIcon = LOGO_PATH . DS . "images" . DS . "icons_cat"; // مسار الايقونات
            // جلب الايقون القديمة
            $catOld = $cat->getByColumn("categorie_id", $_POST["catId"]);
            if ( $cat->checkInput("edit") ) {
                $result["status"] = "error";
                $result["message"] =  $cat->showMessages();
            } else {
                if ( !empty($_FILES["uploadIconCat"]) ) {
                    $newNameFile = uniqid() . "." . pathinfo($_FILES["uploadIconCat"]["name"], PATHINFO_EXTENSION);
                    // خذف الايقونة القديمة
                    if ( file_exists($dirIcon . DS . $catOld->categorie_icon) ) {
                        unlink($dirIcon . DS . $catOld->categorie_icon);
                    }
                    if ( move_uploaded_file($_FILES["uploadIconCat"]["tmp_name"], $dirIcon . DS . $newNameFile) ) {
                        $cat->categorie_icon = $newNameFile;
                    }
                } else { // في حال عدم اختيار ايقونة
                    $cat->location_icon = $catOld->categorie_icon;
                }
                $cat->update();
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageEditCat", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function deleteCategoriesAction(){
        if ( isset($_POST["delete"]) ) {
            $cat = new cateogriesModals();
            $id = $this->filterInt($_POST["id"]);
            $cat->categorie_id = $id;
            $getIcon = $cat->getByKey();
            if ( $cat->delete(" where categorie_id = $id") ) {
                $dirIcon = LOGO_PATH . DS . "images" . DS . "icons_cat" . DS . $getIcon->categorie_icon;
                if ( is_file($dirIcon) ) {
                    unlink($dirIcon);
                }
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageDeleteCat", $GLOBALS["lang"]));
            } else {
                $result["message"] = $this->messageAjaxError(\syriashop\lib\Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        } else {
            $this->headerTo("/client/");
        }
    }
    public function getCatByIdAction(){
        if ( $_POST["getCat"] ) {
            $id = $this->filterInt($_POST["id"]);
            $cat = new cateogriesModals;
            $getCat = $cat->getByColumn("categorie_id", $id);
            if ( !empty($getCat) ) {
                $result["status"] = "success";
                $result["message"] = $getCat;
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxSuccess(\syriashop\lib\Languages::lang("dashboardMessageCatNotExists", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
    
    // الابلاغات
    public function ReportsAction(){
        $report = new ReportsItemsModals();
        
        // تعدد الصفحات
        if ( !isset($this->_params[0]) ) {
            $page = 1;
        } else {
            $page = (int) $this->_params[0];
        }
        $records_at_page = COUNT_TABLE; /// كم سجل بدي يظهر
        $record_count = $report->rowCount("reports"); // عدد السجلات
        $pages_count = (int)ceil($record_count / $records_at_page);
        $this->_data["thePage"] = array(
            "page" => $page,
            "pages" => $pages_count
        );
        $start = ($page - 1) * $records_at_page;
        $end = $records_at_page;
        $this->_data["thePage"]['start']  = $start;
        $this->_data["thePage"]['end']  = $end;
        
        $sqlReport = $report->sql("*", "reports", "ORDER BY report_id ASC LIMIT $start, $end", null, "all");
        $this->_data["allReports"] = !empty($sqlReport) ? $sqlReport : $this->message("blue", \syriashop\lib\Languages::lang("dashboardNotFoundReports", $GLOBALS["lang"]));
        
        // جلب جميع الاقسام
        $getAllReports = $report->getAll();
        $this->_data["getAllReports"] = $getAllReports;
        
        $this->_view();
    }
    public function deleteReportAction(){
        if ( isset($_POST["deleteReport"]) ) {
            $id = $this->filterInt($_POST["id"]);
            $report = new ReportsItemsModals();
            if ( $report->delete(" WHERE report_id = $id") ) {
                $result["status"] = "success";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("dashboardMessageDeleteReport", $GLOBALS["lang"]));
            } else {
                $result["status"] = "error";
                $result["message"] = $this->messageAjaxSuccess(Languages::lang("AnUnexpectedErrorOccurred", $GLOBALS["lang"]));
            }
            header("content-type: application/json");
            echo json_encode($result);
        }
    }
}
