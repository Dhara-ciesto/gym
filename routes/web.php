<?php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Route::get('/', function () {
//     return view('welcome');
// });
Route::any('/expensegstreportmember/excel', 'MemberReportController@expensegstreport')->name('expensegstreport.excel');
Route::any('sendmemberform', 'SendMemberFormController@sendmemberform')->name('sendmemberform');
Route::any('{id}/addmember', 'SendMemberFormController@addmeber');
Route::any('BookTrainer', 'TrainerProfileControllerApp@BookTrainer');
Route::any('viewtrainersApp/{id}', 'TrainerProfileControllerApp@viewtrainers')->name('viewtrainersApp');
Route::any('viewtrainerprofileApp/{id}', 'TrainerProfileControllerApp@viewtrainerprofile')->name('viewtrainerprofileApp');
Route::any('transactionpaymentreceipt/{id}/{code}', 'PaymentController@transactionpaymentreceipt')->name('transactionpaymentreceipt');
Route::get('/', function () {
    return redirect('adminloginpage');
})->middleware('Checkip');
Route::any('/adminloginpage', 'AdminController@loginpage')->middleware('Checkip');
Route::any('/memberlogin', 'MemberLoginController@memberlogin')->middleware('Checkip');
Route::any('/memberdashboard/{userid?}', 'MemberLoginController@memberdashboard')->middleware('Checkip');
//
Route::any('check', 'AdminController@check')->name('check');
Route::group(['middleware' => ['admin']], function () {
    Route::get('dashboard', 'AdminController@dashboard')->name('dashboard');
    Route::any('admin', 'AdminController@login');
    Route::any('addrootscheme', 'RootSchemeController@create');
    Route::any('addscheme', 'SchemeController@create');
    Route::get('rootschemes', 'RootSchemeController@index');
    Route::any('editrootscheme/{id}', 'RootSchemeController@editrootscheme');
    Route::get('deleterootscheme/{id}', 'RootSchemeController@destroy');
    Route::get('deleteterm/{id}', 'TermsController@destroy');
    Route::any('editscheme/{id}', 'SchemeController@editscheme');
    Route::get('deletescheme/{id}', 'SchemeController@destroy');
    Route::get('terms', 'TermsController@index');
    Route::any('addterms', 'TermsController@create');
    Route::any('editterm/{id}', 'TermsController@editterms');
    Route::get('assignedterms', 'AssignTermsController@index');
    Route::any('assignterms', 'AssignTermsController@create');
    Route::any('editassignterms/{id}', 'AssignTermsController@editassignterms');
    Route::any('schemes', 'SchemeController@index');
    Route::any('addMember/{id?}', 'MemberController@otpverify');
    Route::any('members', 'MemberController@index')->name('memberindex');
    Route::any('activemembers', 'MemberController@activemembers')->name('memberindex');
    Route::any('extendreport', 'MemberController@extendreport')->name('extendreport');

    Route::any('inquiry', 'InquiryOneController@index');
    Route::any('closeinquiry/{id}', 'InquiryOneController@closeinquiry');
    Route::any('changeinqstatus', 'InquiryOneController@changeinqstatus');
    Route::any('viewclosedinquiry', 'InquiryOneController@viewclosedinquiry');
    Route::get('/logout', 'AdminController@logout')->name('logout');
    Route::any('addReason', 'ReasonController@create');
    Route::any('editReason/{id}', 'ReasonController@editReason');
    Route::get('reasons', 'ReasonController@index');
    Route::any('assignPackage', 'MemberController@createPayment');
    Route::any('editrole/{id}', 'RoleController@editRole');
    Route::any('editMember/{id1}', 'MemberController@editMember');
    Route::get('deleterole/{id}', 'RoleController@destroy');
    Route::any('addrole', 'RoleController@create');
    Route::any('roles', 'RoleController@index');
    Route::any('deactiverole/{id}', 'RoleController@deactiverole')->name('deactiverole');
    Route::any('deactivateuser/{id}', 'UserController@deactivateuser')->name('deactivateuser');

    Route::any('users', 'UserController@index');
    Route::any('addUser', 'UserController@create');
    Route::any('edituser/{id}', 'UserController@edituser');
    Route::get('deleteuser/{id}', 'UserController@destroy');
    Route::any('/MemberController/check', 'MemberController@check')->name('MemberController.check');
    Route::post('/PackageController/getuser', 'PackageController@getuser')->name('PackageController.getuser');
    Route::post('/MemberController/scheme', 'MemberController@scheme')->name('scheme');
    Route::get('/MemberController/create', 'MemberController@create')->name('create');
    Route::post('/MemberController/createuser', 'MemberController@createuser')->name('createuser');
    Route::post('/MemberController/edituser', 'MemberController@edituser')->name('edituser');
    Route::post('/MemberController/schemeActualPrice', 'MemberController@schemeActualPrice')->name('schemeActualPrice');
    Route::any('/MemberController/checkmobile', 'MemberController@checkmobile')->name('MemberController.checkmobile');
    Route::post('changedate', 'PackageController@changedate')->name('changedate');
    Route::post('changeenddate', 'PackageController@changeenddate')->name('changeenddate');
    Route::get('paymenttypes', 'PaymentTypeController@index');
    Route::any('addpaymenttype', 'PaymentTypeController@create');
    Route::any('editpaymenttype/{id}', 'PaymentTypeController@editpaymenttype');
    Route::get('deletepaymenttype/{id}', 'PaymentTypeController@destroy');
    Route::get('settings', 'SettingController@index');
    Route::any('addCashCredit', 'PaymentController@create');
    Route::any('posture', 'PostureController@create');
    Route::any('packageEdit/{id}', 'PackageController@packageEdit')->name('packagEdit');
    Route::any('editpackage/{id}', 'PackageController@editpackage');
    Route::any('invoice', 'PaymentController@invoice')->name('invoice');
    Route::any('Printconsentform', 'ProfileController@Printconsentform')->name('Printconsentform');
    Route::any('paymentreceipt', 'ProfileController@paymentreceipt')->name('paymentreceipt');
    Route::post('/SchemeController/check', 'SchemeController@check')->name('SchemeController.check');
    Route::get('demo-generate-pdf', 'ProfileController@demoGeneratePDF');
    Route::any('addinquiry', 'InquiryOneController@add_inquiry');
    Route::any('inquirycheckmobile', 'InquiryOneController@inqcheckmobile');

    Route::any('addinquirydata', 'InquiryOneController@create')->name('addinquirydata');
    Route::any('addCompany', 'CompanyController@create');
    Route::get('company', 'CompanyController@index');
    Route::any('editcompany/{id}', 'CompanyController@editcompany');
    Route::any('followup/{id?}', 'FollowupController@index');
    Route::any('addfollowup/{id}', 'FollowupController@addfollowup');
    Route::any('viewfollowup/{id}', 'FollowupController@viewfollowup');
    Route::any('editfollowupmodel/{id}', 'FollowupController@editfollowupmodel');
    Route::any('viewfollowupcall/{id}', 'FollowupController@viewfollowupcall');
    Route::any('viewfollowupprofile/{id}', 'FollowupController@viewfollowupprofile');
    Route::get('confirminquiry/{id}', 'InquiryOneController@confirminquiry');
    Route::any('editfollowup/{id}', 'FollowupController@editfollowup');
    Route::any('notificationstatus', 'FollowupController@notificationvia')->name('notificationstatus');
    Route::any('smsverify', 'InquiryOneController@otpverify')->name('smsverify');
    Route::any('redendsms', 'InquiryOneController@otpverify')->name('redendsms');
    Route::post('smspostverify', 'InquiryOneController@postverify')->name('postverify');
    Route::post('inquiryotpsend', 'InquiryOneController@inquiryotpsend')->name('inquiryotpsend');
    Route::post('inquiryotpverify', 'InquiryOneController@inquiryotpverify')->name('inquiryotpverify');
    Route::any('editinquiry/{id}', 'InquiryOneController@editinquiry');
    Route::get('memberProfile/{id}', 'ProfileController@profile');
    Route::any('consentform', 'ProfileController@consentform');
    Route::post('/PackageController/getusername', 'PackageController@getusername')->name('PackageController.getusername');
    Route::post('/MemberController/createmember', 'MemberController@createmember')->name('createmember');
    Route::any('verify', 'MemberController@otpverify')->name('otpverify');
    Route::post('postverify', 'MemberController@postverify')->name('postverify');
    Route::any('/NotesController/addnote', 'NotesController@addnote')->name('addnote');
    Route::any('/NotesController/deletenote', 'NotesController@deletenote')->name('deletenote');
    Route::any('/NotesController/viewnote', 'NotesController@viewnote')->name('viewnote');
    Route::post('/NotesController/editnote', 'NotesController@editnote')->name('editnote');
    Route::post('/NotesController/imageupload', 'NotesController@imageupload')->name('imageupload');
    Route::get('idpendingreport', 'MemberController@idpendingreport');
    Route::any('makePayment/{id}', 'PaymentController@remainingpayment');
    Route::any('IDupload', 'ProfileController@IDupload');
    Route::post('editmember/{id}', 'MemberController@editMember');
    Route::any('viewconfirmedinquiry', 'InquiryOneController@viewconfirmedinquiry');
    Route::any('convertmember/{id}', 'InquiryOneController@convertmember');
    Route::any('resendotp/{mobileno}', 'MemberController@otpresendverify')->name('resendotp');
    Route::any('paymentforreceiptno/{ReceiptNo}', 'ProfileController@paymentforreceiptNo')->name('paymentforreceiptNo');
    Route::any('summry', 'PaymentController@summry');
    Route::any('editsetting/{id}', 'SettingController@editsetting');
    Route::any('viewExercise', 'ExerciseController@index');
    Route::any('addExercise', 'ExerciseController@addExercise');
    Route::any('editExercise/{id}', 'ExerciseController@editExercise');
    Route::any('viewExerciseLevel', 'ExerciseLevelController@index');
    Route::any('addExerciseLevel', 'ExerciseLevelController@addExerciseLevel');
    Route::any('editExerciseLevel/{id}', 'ExerciseLevelController@editExerciseLevel');
    Route::any('planExercise', 'ExercisePlanController@addplan');
    Route::any('addplan', 'ExercisePlanController@addplan');
    Route::any('assignExercise/{id?}', 'ExercisePlanController@assignExercise');
    Route::any('packageload', 'ExercisePlanController@packageload')->name('packageload');
    Route::any('assignExercisetoMember', 'ExercisePlanAssignController@assignExercisetoMember')->name('assignExercisetoMember');
    Route::any('ExerciseplanView', 'ExercisePlanController@ExerciseplanView');
    Route::any('exerciseload', 'ExercisePlanController@exerciseload')->name('exerciseload');
    Route::any('editplan', 'ExercisePlanController@editplan');
    Route::post('checkworkout', 'ExercisePlanController@checkworkout')->name('checkworkout');
    Route::any('assignExercisewithMember', 'ExercisePlanAssignController@assignExercisewithMember');
    Route::any('viewWorkout', 'WorkoutController@index');
    Route::any('addWorkout', 'WorkoutController@addWorkout');
    Route::any('editWorkout/{id}', 'WorkoutController@editWorkout');
    Route::any('workoutload', 'ExercisePlanController@workoutload')->name('workoutload');
    Route::any('workoutmemberload', 'ExercisePlanController@workoutmemberload')->name('workoutmemberload');
    Route::any('addMeasurement/{id?}', 'MeasurementController@addMeasurement');
    Route::any('measurementgetuser', 'MeasurementController@measurementgetuser')->name('measurementgetuser');
    Route::any('viewMeasurement', 'MeasurementController@viewMeasurement');
    Route::any('editMeasurement/{id}', 'MeasurementController@editMeasurement');
    Route::any('sessionreport/{tid?}/{mid?}/{pid?}', 'PersonalTrainerController@sessionreport')->name('sessionreport');

    Route::any('deletesession/{id}/{tid?}/{mid?}/{pid?}', 'PersonalTrainerController@deletesession')->name('deletesession');
    Route::any('checktime', 'PackageController@checktime')->name('checktime');
    Route::any('gettrainermember', 'PersonalTrainerController@gettrainermember')->name('gettrainermember');
    Route::any('getsessiontrainermember', 'PersonalTrainerController@getsessiontrainermember')->name('getsessiontrainermember');
    /***************************Excel Report******************************************/
    /*for PT Session Report*/
    Route::any('getexcel', 'PersonalTrainerController@excel')->name('getexcel');
    Route::any('getpackage', 'PersonalTrainerController@getpackage')->name('getpackage');
    Route::any('getqueryresultforexcel', 'PersonalTrainerController@getqueryresultforexcel')->name('getqueryresultforexcel');
    /*for gst*/
    Route::any('gstreport', 'Reports\GSTController@gstreport');
    Route::any('getinquiryexcelreport', 'InquiryOneController@getinquiryexcelreport')->name('getinquiryexcelreport');
    /*for payment Report */
    Route::any('paymentreport', 'PaymentReportController@paymentreport');
    // Route::any('getinquiryexcelreport', 'InquiryOneController@getinquiryexcelreport')->name('getinquiryexcelreport');
    /****************************Excel Report*****************************************/
    Route::any('addMeal', 'MealMasterController@addMeal');
    Route::any('editMeal/{id}', 'MealMasterController@editMeal');
    Route::any('viewMeal', 'MealMasterController@index');
    Route::any('addDietitem', 'DietItemController@addDietitem');
    Route::any('editDietitem/{id}', 'DietItemController@editDietitem');
    Route::any('viewDietitem', 'DietItemController@index');
    Route::any('addDietnote', 'DietNoteController@addDietnote');
    Route::any('editDietnote/{id}', 'DietNoteController@editDietnote');
    Route::any('viewDietnote', 'DietNoteController@index');
    Route::any('planDiet', 'DietPlanController@planDiet');
    Route::any('editDietplan', 'DietPlanController@viewDietplan');
    Route::any('checkdietname', 'DietPlanController@checkdietname');
    Route::any('dietload', 'DietPlanController@dietload')->name('dietload');
    Route::any('dietpackageload', 'MemberDietPlanController@dietpackageload')->name('dietpackageload');
    Route::any('assigndiettomember/{id?}', 'MemberDietPlanController@assigndiettomember');
    Route::any('memberdietassign', 'MemberDietPlanController@memberdietassign');
    Route::any('assigndietmember', 'MemberDietPlanController@assigndietmember');
    Route::any('dietplanload', 'MemberDietPlanController@dietplanload')->name('dietplanload');
    Route::any('dietmemberload', 'MemberDietPlanController@dietmemberload')->name('dietmemberload');
    Route::any('dietpdf/{id}', 'DietPlanController@dietplanpdf')->name('dietpdf');
    Route::any('exercisepdf/{id}', 'ExercisePlanController@exercisepdf')->name('exercisepdf');
    Route::any('deletedocs', 'UserController@deletedocs')->name('deletedocs');
    /********************************Regisration route list***************************************/
    Route::any('registration#tologin', 'RegistrationController@index')->name('registration#tologin');
    Route::get('deletedregstration', 'RegistrationController@expirreg')->name('deletedregstration');
    Route::post('deleteregistration', 'RegistrationController@deleteregistration')->name('deleteregistration');
    Route::any('registrationdetails', 'RegistrationController@show')->name('registrationdetails');
    Route::any('registration', ['as' => 'registration', 'uses' => 'RegistrationController@create']);
    Route::any('viewregistrationdetails/{id}', 'RegistrationController@viewregistrationdetails');

    Route::any('registrationindex', ['as' => 'registrationindex', 'uses' => 'RegistrationController@index']);
    Route::any('generate-registrationpdf', 'RegistrationController@generateregistrationPDF')->name('generate-registrationpdf');
    Route::any('regresendotp', 'MemberController@otpresendverify')->name('regresendotp');
    Route::any('regajax', 'InquiryController@regajax')->name('regajax');
    Route::any('otpverify', 'RegistrationController@otpverify')->name('otpverify');
    Route::any('rpostverify', 'RegistrationController@rpostverify')->name('rpostverify');
    Route::any('regconvertmember/{id}', 'RegistrationController@convertmember');
    //Route::any('convertmember/{id}','RegistrationController@convertmember');
    Route::any('deletereg/{id}', 'RegistrationController@deletereg')->name('deletereg');
    Route::any('assessment', ['middleware' => 'admin', 'as' => 'assessment', 'uses' => 'PostureController@assessment']);
    Route::any('getmobilenoforassesment', ['middleware' => 'admin', 'as' => 'getmobilenoforassesment', 'uses' => 'PostureController@getmobilenoforassesment']);
    Route::any('viewassesment', ['middleware' => 'admin', 'uses' => 'PostureController@viewassessment'])->name('viewassesment');
    Route::any('editAssesment/{id}', ['middleware' => 'admin', 'uses' => 'PostureController@editAssesment'])->name('editAssesment');
    Route::any('assessmentajax', ['middleware' => 'admin', 'as' => 'assessmentajax', 'uses' => 'PostureController@assessmentajax']);
    Route::post('skipregotp', 'RegistrationController@skipotp')->name('skipregotp');
    Route::any('setExpiry', 'MemberController@setExpiry');
    /*********************reg route *dhara*******************************/
    Route::any('addregpaymenttype', 'RegPaymentMasterController@addregpaymenttype');
    Route::any('regpaymenttype', 'RegPaymentMasterController@regpaymenttype');
    Route::any('loadreghistory', 'RegistrationController@loadreghistory')->name('loadreghistory');
    Route::any('getpriceofregtype', 'RegistrationController@getpriceofregtype')->name('getpriceofregtype');
    Route::any('editregpaymenttype/{id}', 'RegPaymentMasterController@editregpaymenttype');
    /*******************\End *reg route *dhara*********************************/
    /**************************payment route *parth********************************************************/
    Route::get('assignPackageOrRenewalPackage/{id?}', 'PaymentController@demopayment')->name('assignPackageOrRenewalPackage');
    // Route::get('demopayment','PaymentController@demopayment')->name('demopayment');
    Route::post('placeorder', 'PaymentController@placeorder')->name('placeorder');
    Route::post('placeorderfinal', 'PaymentController@placeorderfinal')->name('placeorderfinal');
    Route::any('transactionfinalforpackage', 'PaymentController@transactionfinalforpackage')->name('transactionfinalforpackage');
    Route::any('remainingplaceorder/{id}', 'PaymentController@remainingplaceorder')->name('remainingplaceorder');
    Route::any('remainingplaceorderprocess/{id}', 'PaymentController@remainingplaceorderprocess')->name('remainingplaceorderprocess');
    Route::post('remainingpaymentfinal', 'PaymentController@remainingpaymentfinal')->name('remainingpaymentfinal');
    Route::post('remainingpaymentstore', 'PaymentController@remainingpaymentstore')->name('remainingpaymentstore');
    Route::get('regpaymentview', 'PaymentController@regpaymentview')->name('regpaymentview');
    Route::get('placeorderforregstration', 'PaymentController@placeorderforregstration')->name('placeorderforregstration');
    Route::post('getuseridforpayment', 'PackageController@getuseridforpayment')->name('getuseridforpayment');
    Route::post('schemeforpayment', 'PackageController@schemeforpayment')->name('schemeforpayment');
    Route::get('placeorder', function () {
        return redirect('assignPackageOrRenewalPackage');
    });
    Route::get('placeorderfinal', function () {
        return redirect('assignPackageOrRenewalPackage');
    });
    Route::get('remainingpaymentfinal', function () {
        return redirect('dashboard');
    });
    Route::get('remainingpaymentstore', function () {
        return redirect('dashboard');
    });
    Route::get('placeorderforregstration', function () {
        return redirect('dashboard');
    });
    /***********************\\End **payment route *parth****************************************************/
    /*************************************************/
    Route::get('regpaymentview', 'PaymentController@regpaymentview')->name('regpaymentview');
    Route::post('placeorderforregstration', 'PaymentController@placeorderforregstration')->name('placeorderforregstration');
    Route::get('receiptforregister/{id}', 'PaymentController@receiptforregister')->name('receiptforregister');
    /*********************************************************/
    /*******************************end *Regisration route list***************************************/
    /*********************************Any time acces card*****************************************/
    Route::any('addanytimeaccesscard', 'anytimeaccess\AnyTimeAccessController@addanytimeaccesscard');
    Route::any('editanytimeaccesscard/{id}', 'anytimeaccess\AnyTimeAccessController@editanytimeaccesscard');
    Route::any('viewanytimeaccesscard', 'anytimeaccess\AnyTimeAccessController@index');
    Route::any('atacardassigntomember', 'anytimeaccess\AnyTimeAccessController@atacardassigntomember');
    Route::any('viewbeltdataajax', 'anytimeaccess\AnyTimeAccessController@viewbeltdataajax')->name('viewbeltdataajax');
    Route::any('returnuserbelt', 'anytimeaccess\AnyTimeAccessController@returnuserbelt');
    Route::any('anytimeaccesscardreport', 'anytimeaccess\AnyTimeAccessReportController@anytimeaccessreport');
    /***************************End *Any time acces card********************************/
    /////////////////// device setting for portal start //////////////////////////////////
    Route::any('edit_device/{id}', 'PortaldeviceController@editdevice')->name('editdevice');
    Route::any('delete/{id}', 'PortaldeviceController@deletedevice')->name('deletedevice');
    Route::get('connection/check', 'PortaldeviceController@connectioncheck')->name('connectioncheck');
    Route::post('setexpiryofregister', 'PortaldeviceController@setexpiry')->name('setexpiryofregister');
    Route::post('setExpirypackage', 'PortaldeviceController@setExpirypackage')->name('setExpirypackage');
    Route::post('check_expiry', 'PortaldeviceController@check_expiry')->name('check_expiry');
    Route::post('setexpiryofemp', 'PortaldeviceController@setexpiryofemp')->name('setexpiryofemp');
    Route::post('setmemberenroll', 'PortaldeviceController@setmemberenroll')->name('setmemberenroll');
    Route::post('deactivemember', 'PortaldeviceController@deactivemember')->name('deactivemember');
    Route::post('activemember', 'PortaldeviceController@activemember')->name('activemember');
    /////////////////////////////// device setting for portal end ////////////////////////////////////
    //////////////////////////////////// extend expiry of registration ////////////////////////////////
    Route::post('sendotptoadmin', 'RegistrationController@sendotptoadmin')->name('sendotptoadmin');
    Route::post('sendotptoadminforpackagedate', 'ProfileController@sendotptoadminforpackagedate')->name('sendotptoadminforpackagedate');
    Route::post('setextendedpackagedate', 'ProfileController@setextendedpackagedate')->name('setextendedpackagedate');
    Route::post('setextendedregdate', 'RegistrationController@setextendedregdate')->name('setextendedregdate');
    Route::get('catch', 'RegistrationController@catchmethod');
    // --------OTP------------------
    Route::any('smsverify', 'InquiryController@otpverify')->name('smsverify');
    Route::any('redendsms', 'InquiryController@otpverify')->name('redendsms');
    Route::post('smspostverify', 'InquiryController@postverify')->name('postverify');
    Route::post('regpostverify', 'RegistrationController@regpostverify')->name('regpostverify');
    Route::post('deleteregistration', 'RegistrationController@deleteregistration')->name('deleteregistration');
    Route::post('registrationresendotp', 'RegistrationController@regresendotp')->name('registrationresendotp');
    Route::post('schemeforregistration', 'RegistrationController@schemeforregistration')->name('schemeforregistration');
    // -------------------------------------------------------------------------

    Route::any('pinsend/{id}', ['middleware' => 'admin', 'as' => 'pinsend', 'uses' => 'ProfileController@pinsend']);
    Route::any('pinchange/{id}', ['middleware' => 'admin', 'as' => 'pinchange', 'uses' => 'ProfileController@pinchange']);
    Route::get('get-curl', 'SmsController@getCURL');
    Route::any('test', 'TestController@test')->name('test');
    Route::any('testuu', 'TestController@testuserupload')->name('testuu');


    // ------------ Device -------------

    Route::any('adddevice', 'SettingController@adddevice')->name('adddevice');
    Route::post('setuser', 'ProfileController@setuser');
    Route::post('setuserfromsummary', 'DeviceController@setuserfromsummary')->name('setuserfromsummary');
    Route::get('enrolluserfromsummary', 'DeviceController@enrolluserfromsummary')->name('enrolluserfromsummary');
    Route::post('enrolluser', 'ProfileController@enrolluser');
    Route::post('enrollcard', 'ProfileController@enrollcard');
    Route::post('reassigncard', 'ProfileController@reassigncard');
    Route::post('setvaliditytodevice', 'ProfileController@setvaliditytodevice');
    Route::post('deactivedeviceuser', 'ProfileController@deactivedeviceuser');
    Route::post('activedeviceuser', 'ProfileController@activedeviceuser');
    Route::any('deactivedeviceemployee', 'DeviceController@deactivedeviceemployee');
    Route::any('activedeviceemployee', 'DeviceController@activedeviceemployee');
    Route::post('userfetchlogs', 'ProfileController@userfetchlogs');
    Route::get('viewdevice', 'SettingController@viewdevice')->name('viewdevice');
    Route::any('cardread', 'SettingController@cardread');
    Route::any('fetchlogs', 'DeviceController@fetchlogs');
    Route::any('vfl', 'DeviceController@test');
    Route::any('devicestatus', ['middleware' => 'admin', 'as' => 'devicestatus', 'uses' => 'DeviceController@devicestatus']);
    Route::any('viewfetchlogs', 'DeviceController@viewfetchlogs');
    Route::post('setemployee', 'DeviceController@setemployee');
    Route::post('enrollemployee', 'DeviceController@enrollemployee');
    Route::post('enrollemployeecard/{id}', 'DeviceController@enrollemployeecard');
    Route::any('enrolldevicecomman/{id?}', 'DeviceController@enrolldevicecomman');
    Route::any('enrolldevicecommanemp/{id?}', 'DeviceController@enrolldevicecommanemp');
    Route::any('extendexpiry', 'DeviceController@extendexpiry');
    Route::any('enrollcardcomman', 'DeviceController@enrollcardcomman');
    Route::any('reassigncard1details', 'DeviceController@reassigncard1details');
    Route::get('getuserajax', 'DeviceController@getuserajax');
    Route::get('userenrollstatus', 'DeviceController@userenrollstatus');
    Route::any('devicedatabackup', 'DeviceController@devicedatabackup');
    Route::any('fetchdeviceuserconfig', 'DeviceController@fetchdeviceuserconfig');
    Route::any('apischedual', 'DeviceController@apischedual');
    Route::any('userenrollmemberpackagesdetails', 'DeviceController@userenrollmemberpackagesdetails');
    Route::any('summarymaxexpiry', 'DeviceController@summarymaxexpiry');
    ///////////////// Settings Routes //////////////////////
    Route::any('msgsettings', 'SettingController@msgsettings');
    Route::any('smsbalance', 'SettingController@smsbalance');
    Route::any('emailsettings', 'SettingController@emailsettings');
    Route::any('smssettings', 'SettingController@smssettings');
    Route::any('editsmssettings', 'SettingController@editsmssettings');
    Route::any('geteditsmssettings', 'SettingController@geteditsmssettings');
    Route::any('urltest', 'SettingController@urltest');
    Route::any('urltestsave', 'SettingController@urltestsave');
    Route::any('urltestdemo', 'SettingController@urltestdemo');
    /////////// SMS(Notification) Dashboard ///////////////
    //Route::any('addsms', 'sms\NotificationController@index')->name('addsms');
    Route::any('editsms', 'sms\NotificationController@editsms')->name('editsms');
    Route::any('addnewtemplate', 'sms\NotificationController@addnewtemplate')->name('addnewtemplate');
    Route::any('getsmsdata', 'sms\NotificationController@getsmsdata')->name('getsmsdata');
    Route::any('editsmsdata', 'sms\NotificationController@editsmsdata')->name('editsmsdata');
    Route::any('sendsms', 'sms\NotificationController@sendsms')->name('sendsms');
    Route::any('sendinquirysms', 'sms\InquirySMSController@inqsms')->name('inqsms');
    Route::any('directmessage/{id?}', 'sms\NotificationController@directmessage')->name('directmessage');
    Route::any('sendregistrationsms', 'sms\NotificationController@sendregistrationsms')->name('sendregistrationsms');
    Route::any('smssearch', 'sms\NotificationControllerajax@smssearch')->name('smssearch');
    Route::any('sendsmsuser', 'sms\NotificationControllerajax@sendsmsuser')->name('sendsmsuser');
    Route::any('reminder', 'sms\NotificationController@reminder')->name('reminder');
    Route::any('fetchsmslogs', 'sms\NotificationController@fetchsmslog')->name('fetchsmslogs');
    Route::any('smsresponse', 'sms\NotificationControllerajax@smsresponse')->name('smsresponse');
    Route::any('sendsmsinquirytouser', 'sms\NotificationController@sendsmsinquirytouser')->name('sendsmsinquirytouser');
    ////////////// Payment Modual //////////////////////////////
    Route::get('demopayment', 'PaymentController@demopayment')->name('demopayment');
    Route::post('placeorder', 'PaymentController@placeorder')->name('placeorder');
    Route::post('placeorderfinal', 'PaymentController@placeorderfinal')->name('placeorderfinal');
    Route::any('transactionfinalforpackage', 'PaymentController@transactionfinalforpackage')->name('transactionfinalforpackage');
    // Route::any('transactionpaymentreceipt/{id}', 'PaymentController@transactionpaymentreceipt')->name('transactionpaymentreceipt');
    Route::any('remainingplaceorder/{id}', 'PaymentController@remainingplaceorder')->name('remainingplaceorder');
    Route::post('getuseridforpayment', 'PackageController@getuseridforpayment')->name('getuseridforpayment');
    Route::post('schemeforpayment', 'PackageController@schemeforpayment')->name('schemeforpayment');
    Route::any('memberpackagehistory', 'PackageController@memberpackagehistory')->name('memberpackagehistory');
    ////////////////// Email Notification ////////////////
    Route::get('/send/email', 'sms\NotificationController@mail');
    //////////////  ReUse RFIT //////////////////
    /////////////////////////////////////////// Package upgrade start ///////////////////////////////////////////////////
    Route::get('packageupgrade', 'PackageUpgradeController@packageupgrade')->name('packageupgrade');
    Route::post('memberpackageforupgrade', 'PackageUpgradeController@memberpackageforupgrade')->name('memberpackageforupgrade');
    Route::post('peiceformemberpackage', 'PackageUpgradeController@peiceformemberpackage')->name('peiceformemberpackage');
    Route::post('peiceforupgradepackage', 'PackageUpgradeController@peiceforupgradepackage')->name('peiceforupgradepackage');
    Route::post('verifyotpforpackage', 'PackageUpgradeController@verifyotpforpackage')->name('verifyotpforpackage');
    Route::post('packageupgradeorder', 'PackageUpgradeController@packageupgradeorder')->name('packageupgradeorder');
    Route::post('oldpackagedetail', 'PackageUpgradeController@oldpackagedetail')->name('oldpackagedetail');
    Route::post('upgradepackagepayment', 'PackageUpgradeController@upgradepackagepayment')->name('upgradepackagepayment');
    Route::post('rootschemeforpackageupgrade', 'PackageUpgradeController@rootschemeforpackageupgrade')->name('rootschemeforpackageupgrade');
    Route::get('upgradepackagedetails', 'PackageUpgradeController@upgradepackagedetails')->name('upgradepackagedetails');
    Route::post('checkupgradepackage', 'PackageUpgradeController@checkupgradepackage')->name('checkupgradepackage');
    Route::post('checkifupgrade', 'PackageUpgradeController@checkifupgrade')->name('checkifupgrade');
    Route::get('packageupgradeorder', function () {
        return route('packageupgrade');
    })->name('packageupgradeorder');
    Route::get('upgradepackagepayment', function () {
        return route('packageupgrade');
    })->name('upgradepackagepayment');
    /////////////////////////////////////////// Package upgrade end ////////////////////////////////////////////////////
    Route::get('editregistration/{id}', 'RegistrationController@editregistration')->name('editregistration');
    Route::post('sendotptoadminforpackagedate', 'ProfileController@sendotptoadminforpackagedate')->name('sendotptoadminforpackagedate');
    Route::any('memberreport', 'MemberReportController@memberreport');
    //  Route::any('memberreport','MemberReportController@memberreport');
    ////////////////////////////////////////////////// Freeze Membership start /////////////////////////////////////////////////
    Route::get('freezemembership', 'FreezemembershipController@freezemembership')->name('freezemembership');
    Route::get('freezemembershipreceipt/{id}', 'FreezemembershipController@freezemembershipreceipt')->name('freezemembershipreceipt');
    Route::post('selectactivemember', 'FreezemembershipController@selectactivemember')->name('selectactivemember');
    Route::post('checkfreezedate', 'FreezemembershipController@checkfreezedate')->name('checkfreezedate');
    Route::post('freezemembershippayment', 'FreezemembershipController@freezemembershippayment')->name('freezemembershippayment');
    Route::post('freezemembershippaymentstore', 'FreezemembershipController@freezemembershippaymentstore')->name('freezemembershippaymentstore');
    Route::any('viewfreezemembeship', 'FreezemembershipController@viewfreezemembeship')->name('viewfreezemembeship');
    Route::post('freezemembershipdevice', 'FreezemembershipController@freezemembershipdevice')->name('freezemembershipdevice');
    Route::post('unfreezemembership', 'FreezemembershipController@unfreezemembership')->name('unfreezemembership');
    Route::get('freezemembershippaymentstore', function () {
        return redirect('dashboard');
    })->name('freezemembershippaymentstore');
    Route::get('freezemembershippaymentstore', function () {
        return redirect('dashboard');
    })->name('freezemembershippayment');
    ////////////////////////////////////////////////// Freeze Membership end /////////////////////////////////////////////////
    /***********************************Transfer Membership*******************************************/
    Route::any('addtransfermembership', 'TransferMembership\TransferMembershipController@addtransfermembership');
    Route::any('viewtransfermembership', 'TransferMembership\TransferMembershipController@viewtransfermembership');
    Route::any('getactivepackages', 'TransferMembership\TransferMembershipController@getactivepackages')->name('getactivepackages');
    Route::any('transferotpsend', 'TransferMembership\TransferMembershipController@sendotp')->name('transferotpsend');
    Route::any('transferotpverify', 'TransferMembership\TransferMembershipController@transferotpverify')->name('transferotpverify');
    Route::any('sendotp', 'ProfileController@sendotp')->name('sendotp');
    /**********************************End**Transfer Membership********************************************/

    //////////////////////////////////// device status ///////////////////////////////////////////////////////
    Route::any('devicestatusheader', 'DeviceController@devicestatusheader')->name('devicestatusheader');
    Route::any('ifuserset', 'DeviceController@ifuserset')->name('ifuserset');
    Route::any('cardexist', 'DeviceController@cardexist')->name('cardexist');
    Route::any('enrollfinalcard', 'DeviceController@enrollfinalcard')->name('enrollfinalcard');
    Route::any('cardfree', 'DeviceController@cardfree');
    Route::any('Checkbeltname', 'anytimeaccess\AnyTimeAccessController@Checkbeltname')->name('Checkbeltname');
    Route::any('enrollanytimeaccesscard', 'anytimeaccess\AnyTimeAccessController@enrollanytimeaccesscard')->name('enrollanytimeaccesscard');
    Route::any('devicestatuscheck', 'DeviceController@devicestatusheadercheck')->name('devicestatuscheck');
    Route::any('internetstatus', 'DeviceController@internetstatus')->name('internetstatus');
    Route::any('apilist', 'DeviceController@apilist')->name('apilist');
    Route::any('searchapi', 'DeviceController@searchapi')->name('searchapi');
    Route::any('todaymember', 'AdminController@todaymember')->name('todaymember');
    /********************Expense*************************************/
    Route::any('editExpenseitem/{id}', 'ExpenseController@editExpenseitem');
    Route::any('editExpenseitems/{id}', 'ExpenseController@editExpenseitems');
    Route::any('viewexpense', 'ExpenseController@index');
    Route::any('addbank', 'ExpenseController@addbank');
    Route::any('viewbank', 'ExpenseController@viewbank');
    Route::any('editbank/{id}', 'ExpenseController@editbank');
    Route::any('viewexpenses', 'ExpenseController@viewDietitem1');
    Route::any('addexpense', 'ExpenseController@addDietitem');
    /*******************\End *reg route *dhara*********************************/
    Route::any('addexpenses', 'ExpenseController@addDietitem1');
    Route::any('monthlyreport', 'ExpenseController@monthlyreport');
    Route::any('/expensegstreport/excel', 'ExpenseController@expensegstreport')->name('expensegstreport.excel');
    Route::any('/expensegstreport1/excel', 'PaymentReportController@expensegstreport1')->name('expensegstreport1.excel');
    /*********************End **Expense**********************************/
    Route::any('viewquestion', 'ExpenseController@viewquestion');
    Route::any('addquestion', 'ExpenseController@addquestion');
    Route::any('editquestion/{id}', 'ExpenseController@editquestion');
    Route::any('viewuserreuest', 'ExpenseController@viewuserreuest');
    Route::any('edituserreuest/{id}', 'ExpenseController@edituserreuest');
    Route::any('resolverequest/{id}',  'ExpenseController@resolverequest')->name('resolverequest');

    /************************************start dashboard route****************************/
    Route::any('loaduserbytype', 'AdminController@loaduserbytype')->name('loaduserbytype');
    Route::any('loaduserprofile', 'AdminController@loaduserprofile')->name('loaduserprofile');
    /************************************end dashboard route****************************/

    Route::any('addtrainerprofile', 'TrainerProfileController@addtrainerprofile')->name('addtrainerprofile');
    Route::any('viewtrainers', 'TrainerProfileController@viewtrainers')->name('viewtrainers');
    Route::any('viewtrainerprofile/{id}', 'TrainerProfileController@viewtrainerprofile')->name('viewtrainerprofile');
    Route::any('gettrainerdetail', 'TrainerProfileController@gettrainerdetail')->name('gettrainerdetail');
    Route::any('activityreport', 'ActivityReportController@activityreport')->name('activityreport');

    //////////////////////////////////////////// HR Module End ///////////////////////////////////////////////////////////
    Route::any('employeepinchange/{id}', 'UserController@employeepinchange')->name('employeepinchange');
    /****************************start generate short link************************************/
    Route::get('generate-shorten-link', 'ShortLinkController@index');
    Route::post('generate-shorten-link', 'ShortLinkController@store')->name('generate.shorten.link.post');
    Route::get('sendmemberform1/{code}', 'ShortLinkController@shortenLink')->name('pshorten.link');
    /**********************************************************************************/

    Route::any('viewrequests', 'SendMemberFormController@viewrequests');
    Route::any('viewsentforms', 'SendMemberFormController@viewsentforms');
    Route::any('sendformtonumber', 'SendMemberFormController@sendformtonumber');
    Route::any('changeMemberStatus', 'SendMemberFormController@changeMemberStatus');
    Route::any('rejectrequest/{id}', 'SendMemberFormController@rejectrequest');
    Route::any('smsafterpack', 'SendSmsEmailController@smsafterpack');
    Route::any('emailafterpack', 'SendSmsEmailController@emailafterpack');

    /*************************Reports Routes************************************* */
    Route::any('expiredmemberreport', 'Reports\ExpiredMemberReportController@expiredmemberreport');
    Route::any('expiredmemberreport/excel', 'Reports\ExpiredMemberReportController@expiredmemberexcel');
    Route::any('expirereport', 'ExpireController@expirereport');


    Route::any('addpassword', 'PasswordsettingsController@addpassword');
    Route::any('viewpassword', 'PasswordsettingsController@index');
    Route::any('editpassword/{id}', 'PasswordsettingsController@editpassword');
    Route::any('checkexcelpwd', 'PasswordsettingsController@checkexcelpwd');

    /************************************************************** */
    Route::any('remianingamount/sendsmsyes', 'SendPaymentSMSController@sendsmsyes');




    /**********************End ***Reports Routes************************************* */
    /***********************Testing Routes*****************************************
   Route::get("tests", function() {
      return view('script_apischedule');
      });
      Route::get("device_status", function() {
      return view('device_status');
      });
      Route::get("tests2", function() {
      return view('script_apicron');
      });
      Route::get("tests3", function() {
      return view('script_device_user_data_backup');
      });
      Route::get("tests4", function() {
      return view('script_emplog');
      });
      Route::get("demo", function() {
      return view('demo');
      });
      Route::get("script_fetchlog_userlogtable", function() {
      return view('script_fetchlog_userlogtable');
      });
      Route::get("script_failed_api_mail", function() {
      return view('script_failed_api_mail');
      });
     ****************************************************************/
});
Route::group(['prefix' => 'personaltrainer'], function () {
    Route::any('addptlevel', ['middleware' => 'admin', 'as' => 'addptlevel', 'uses' => 'PersonalTrainerController@addptlevel']);
    Route::post('addptleveldatacreate', ['middleware' => 'admin', 'as' => 'addptleveldatacreate', 'uses' => 'PersonalTrainerController@addptleveldatacreate']);
    Route::any('editptlevel/{id}', ['middleware' => 'admin', 'as' => 'editptlevel', 'uses' => 'PersonalTrainerController@editptlevel']);
    Route::any('assignptlevel', ['middleware' => 'admin', 'as' => 'assignptlevel', 'uses' => 'PersonalTrainerController@assignptlevel']);
    Route::any('addpttime', ['middleware' => 'admin', 'as' => 'addpttime', 'uses' => 'PersonalTrainerController@assignPTTime']);
    Route::any('assignmembertotrainer/{id?}', ['middleware' => 'admin', 'as' => 'assignmembertotrainer', 'uses' => 'PersonalTrainerController@assignmembertotrainer']);
    Route::any('manageassignedmember', ['middleware' => 'admin', 'as' => 'manageassignedmember', 'uses' => 'PersonalTrainerController@manageassignedmember']);
});
Route::get('assignptlevelmobileno', ['middleware' => 'admin', 'as' => 'assignptlevelmobileno', 'uses' => 'PersonalTrainerController@assignptlevelajax']);
Route::get('assignptmembermobileno', ['middleware' => 'admin', 'as' => 'assignptmembermobileno', 'uses' => 'PersonalTrainerController@assignptmemberajax']);
Route::get('assignptmemberpackage', ['middleware' => 'admin', 'as' => 'assignptmemberpackage', 'uses' => 'PersonalTrainerController@assignptpackageajax']);
Route::get('edittimeofmember', ['middleware' => 'admin', 'as' => 'edittimeofmember', 'uses' => 'PersonalTrainerController@edittimeofmemberajax']);
Route::get('ajaxgetjoindate', ['middleware' => 'admin', 'as' => 'ajaxgetjoindate', 'uses' => 'PersonalTrainerController@ajaxgetjoindate']);
Route::get('assigntimeslot', ['middleware' => 'admin', 'as' => 'assigntimeslot', 'uses' => 'PersonalTrainerController@assigntimeslotajax']);
Route::get('getpriceofpackage', ['middleware' => 'admin', 'as' => 'getpriceofpackage', 'uses' => 'PersonalTrainerController@getpriceofpackageajax']);
Route::post('assignpttomember', ['middleware' => 'admin', 'as' => 'assignpttomember', 'uses' => 'PersonalTrainerController@assignpttomember']);
Route::post('editassignpttomember', ['middleware' => 'admin', 'as' => 'editassignpttomember', 'uses' => 'PersonalTrainerController@editassignpttomember']);
Route::get('setpercentage', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@setpercentage'])->name('setpercentage');
Route::post('addassignptlevel', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@addassignptlevel'])->name('addassignptlevel');
Route::get('ajaxgetptslot', ['middleware' => 'admin', 'as' => 'ajaxgetptslot', 'uses' => 'PersonalTrainerController@ajaxgetptslot']);
Route::get('ajaxgetptslot', ['middleware' => 'admin', 'as' => 'ajaxgetptslot', 'uses' => 'PersonalTrainerController@ajaxgetptslot']);
Route::post('editassignptlevel', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@editassignptlevel'])->name('editassignptlevel');
Route::any('claimptsession', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@claimptsession'])->name('claimptsession');
Route::any('assignPTTime', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@assignPTTime'])->name('assignPTTime');
Route::any('editpttime', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@editpttime'])->name('editpttime');
Route::get('checkfromdate', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@checkfromdateajax'])->name('checkfromdate');
Route::get('claimptsession', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@claimptsession'])->name('claimptsession');
Route::get('getclaimmember', ['middleware' => 'admin', 'uses' => 'PersonalTrainerController@getclaimmemberajax'])->name('getclaimmember');
Route::post('/UserController/check', 'UserController@check')->name('UserController.check');
Route::get('getnotification', ['middleware' => 'admin', 'as' => 'getnotification', 'uses' => 'FollowupController@ajaxgetnotification']);














/******************HR Module******************* */
Route::get('notification', 'CommonController@notification');
Route::get('method', 'CommonController@method');
Route::any('getcity', 'CommonController@getcity')->name('getcity');
////////////////////////////////////////////////////////// common route end  /////////////////////////////////////////////////////////////





////////////////////////////////////////////////////////// Department route start /////////////////////////////////////////////////////////////
Route::any('department', 'DepartmentController@department')->name('department');
Route::any('viewdepartment', 'DepartmentController@viewdepartment')->name('viewdepartment');
Route::any('updatedept/{id}', 'DepartmentController@updatedepartment')->name('updatedept');
Route::any('activedept/{id}', 'DepartmentController@activeedepartment')->name('activedept');
Route::any('deactivedept/{id}', 'DepartmentController@deactivedepartment')->name('deactivedept');
////////////////////////////////////////////////////////// common route end  /////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////// Employee start //////////////////////////////////////////////////////////////

Route::any('employee', 'EmployeeController@employee')->name('employee');
Route::any('checkuserexist', 'EmployeeController@checkuserexist')->name('checkuserexist');
Route::any('checkmobilenoexist', 'EmployeeController@checkmobilenoexist')->name('checkmobilenoexist');
Route::any('viewemployee', 'EmployeeController@viewemployee')->name('viewemployee');
Route::any('updateemp/{id}', 'EmployeeController@updateemployee')->name('updateemp');
Route::any('activeemp/{id}', 'EmployeeController@activeemployee')->name('activeemp');
Route::any('deactiveemp/{id}', 'EmployeeController@deactiveemployee')->name('deactiveemp');


//////////////////////////////////////////////////////////// Employee end   //////////////////////////////////////////////////////////////

//////////////////////////////////////////// HR Module Start /////////////////////////////////////////////////////////

////////////////////////// working Days ////////////////////////////////////////
Route::any('workingdays', 'HRController@workingdays')->name('workingdays');
Route::any('viewworkingdays', 'HRController@viewworkingdays')->name('viewworkingdays');
Route::any('searchyear', 'HRController@searchyear')->name('searchyear');
Route::any('editworkingdays/{id}', 'HRController@editworkingdays')->name('editworkingdays');
////////////////////////// working Days end ////////////////////////////////////////

////////////////////////// leave Days ////////////////////////////////////////
Route::any('leave', 'HRController@leave')->name('leave');
Route::any('viewleave', 'HRController@viewleave')->name('viewleave');
Route::any('searchleaveyear', 'HRController@searchleaveyear')->name('searchleaveyear');
Route::any('editleave/{id}', 'HRController@editleave')->name('editleave');
Route::any('searcheleave', 'HRController@searcheleave')->name('searcheleave');
////////////////////////// leave Days end ////////////////////////////////////////

///////////////////////////// Employee account start /////////////////////////////////////
Route::any('employeeaccount', 'HRController@employeeaccount')->name('employeeaccount');
Route::any('viewemployeeaccount', 'HRController@viewemployeeaccount')->name('viewemployeeaccount');
Route::any('searchleaveyear', 'HRController@searchleaveyear')->name('searchleaveyear');
Route::any('searchemployeeaccount', 'HRController@searchemployeeaccount')->name('searchemployeeaccount');
Route::any('ajaxgetpendingloan', 'HRController@ajaxgetpendingloan')->name('ajaxgetpendingloan');
Route::any('ajaxgetpendingloandetail', 'HRController@ajaxgetpendingloandetail')->name('ajaxgetpendingloandetail');
///////////////////////////// Employee account end   /////////////////////////////////////

///////////////////////////// Employee log start /////////////////////////////////////
Route::any('employeelog', 'HRController@employeelog')->name('employeelog');
Route::any('employeelogdaywise', 'HRController@employeelogdaywise')->name('employeelogdaywise');
Route::any('callhrdevicelog', 'HRController@callhrdevicelog')->name('callhrdevicelog');




Route::any('storelog', 'HRController@storelog')->name('storelog');
Route::any('addpunch/{id}', 'HRController@addpunch')->name('addpunch');
Route::any('addemppunch', 'HRController@addemppunch')->name('addemppunch');
///////////////////////////// Employee log end ///////////////////////////////////////

///////////////////////////////////// Employee Leave start //////////////////////////////////////////////////////////////
Route::any('employeeleave', 'HRController@employeeleave')->name('employeeleave');
Route::any('addleave', 'EmployeeLeaveController@addleave')->name('addleave');
Route::any('viewleaveentry', 'EmployeeLeaveController@viewleaveentry')->name('viewleaveentry');
Route::any('approveleave/{id}', 'EmployeeLeaveController@approveleave')->name('approveleave');
Route::any('rejectleave/{id}', 'EmployeeLeaveController@rejectleave')->name('rejectleave');
Route::any('changeleavestatus', 'EmployeeLeaveController@changeleavestatus')->name('changeleavestatus');


Route::any('viewemployeeleave', 'HRController@viewemployeeleave')->name('viewemployeeleave');
Route::any('empexpirydate', 'HRController@empexpirydate')->name('empexpirydate');
Route::any('searchemployeeleave', 'HRController@searchemployeeleave')->name('searchemployeeleave');
Route::any('editemployeeleave/{id}', 'HRController@editemployeeleave')->name('editemployeeleave');
Route::any('deleteemployeeleave/{id}', 'HRController@deleteemployeeleave')->name('deleteemployeeleave');
///////////////////////////////////// Employee Leave end //////////////////////////////////////////////////////////////

/////////////////////////////////////////////// salary start ///////////////////////////////////////////////////////////
Route::any('salary', 'HRController@salary')->name('salary');
Route::any('empsalary', 'HRController@empsalary')->name('empsalary');
Route::any('storeempsalary', 'HRController@storeempsalary')->name('storeempsalary');
Route::any('viewsalary', 'HRController@viewsalary')->name('viewsalary');
Route::any('locksalary/{id}', 'HRController@locksalary')->name('locksalary');
Route::any('unlocksalary/{id}', 'HRController@unlocksalary')->name('unlocksalary');
Route::any('viewlockedsalary', 'HRController@viewlockedsalary')->name('viewlockedsalary');
Route::any('viewlockedsalarysearch', 'HRController@viewlockedsalarysearch')->name('viewlockedsalarysearch');
Route::any('editsalary/{id}', 'HRController@editsalary')->name('editsalary');
Route::any('confirmsalary', 'HRController@confirmsalary')->name('confirmsalary');
Route::any('searchsalary', 'HRController@searchsalary')->name('searchsalary');
Route::any('printsalaryslip/{id}', 'HRController@printsalaryslip')->name('printsalaryslip');
/////////////////////////////////////////////// salary end   ///////////////////////////////////////////////////////////

///////////////////////////////////////////////////// Device Start ////////////////////////////////////////////////////
Route::any('hr_adddevice', 'HRDeviceController@adddevice')->name('hr_adddevice');
Route::any('hr_viewdevice', 'HRDeviceController@viewdevice')->name('hr_viewdevice');
Route::any('hr_updatedevice/{id}', 'HRDeviceController@updatedevice')->name('hr_updatedevice');
Route::any('hr_deactivedevice/{id}', 'HRDeviceController@deactivedevice')->name('hr_deactivedevice');
Route::any('hr_activedevice/{id}', 'HRDeviceController@activedevice')->name('hr_activedevice');
///////////////////////////////////////////////////// Device End ////////////////////////////////////////////////////

//////////////////////////////////////////////////// Cron job start ///////////////////////////////////////////////////

Route::get('fetchlogtable', function () {
    return view('script_fetchlog_userlogtable');
});

Route::get("cronjob", function () {
    return view('script_apicron');
});



//////////////////////////////////////////////////// Cron job end  ///////////////////////////////////////////////////

///////////////////////////////////////////////////// enroll employee /////////////////////////////////////////////////
Route::any('enrolldevice', 'EnrollController@enrolldevice')->name('enrolldevice');
Route::any('employeedeviceinfo', 'EnrollController@employeedeviceinfo')->name('employeedeviceinfo');
Route::any('devicelist', 'EnrollController@devicelist')->name('devicelist');
Route::any('empindevice', 'EnrollController@empindevice')->name('empindevice');
Route::any('enrollfingertemplate', 'EnrollController@enrollfingertemplate')->name('enrollfingertemplate');
Route::any('getfingertemplate', 'EnrollController@getfingertemplate')->name('getfingertemplate');
Route::any('checkfingerprint', 'EnrollController@checkfingerprint')->name('checkfingerprint');
Route::any('setfingerprinteachdevice', 'EnrollController@setfingerprinteachdevice')->name('setfingerprinteachdevice');
Route::any('fetchdeviceenroll', 'EnrollController@fetchdeviceenroll')->name('fetchdeviceenroll');
Route::any('getuserdevicelist', 'EnrollController@getuserdevicelist')->name('getuserdevicelist');
Route::any('checksetuser', 'EnrollController@checksetuser')->name('checksetuser');
Route::any('uploadfingerprint', 'EnrollController@uploadfingerprint')->name('uploadfingerprint');
Route::any('deactiveuser', 'EnrollController@deactiveuser')->name('deactiveuser');
Route::any('activeuser', 'EnrollController@activeuser')->name('activeuser');
Route::any('getcontractdate', 'EnrollController@getcontractdate')->name('getcontractdate');
Route::any('setcontractdate', 'EnrollController@setcontractdate')->name('setcontractdate');
Route::any('checkdevicecount', 'EnrollController@checkdevicecount')->name('checkdevicecount');
Route::any('emplog', 'EnrollController@emplog')->name('emplog');
Route::any('emplogajax', 'EnrollController@emplogajax')->name('emplogajax');
Route::any('searchemployeelog', 'HRController@searchemployeelog')->name('searchemployeelog');
Route::any('searchemployeelogdaywise', 'HRController@searchemployeelogdaywise')->name('searchemployeelogdaywise');
///////////////////////////////////////////////////// enroll employee /////////////////////////////////////////////////



//////////////////////////////////////////////////////// Employee Route start /////////////////////////////////////////////////



Route::any('empdashboard', 'EmployeePortal@empdashboard')->name('empdashboard');
Route::any('empprofile', 'EmployeePortal@empprofile')->name('empprofile');
Route::any('emplogemp', 'EmployeePortal@emplogemp')->name('emplogemp');
////////////////////////trial form routes///////////////////////////////////////
Route::any('trialform', 'TrialformController@trialform');
Route::any('viewtrialform', 'TrialformController@viewtrialform');
Route::any('edittrialform/{trailformid}', 'TrialformController@edittrialform');

////////////////////////////end trial form routs///////////////////////////////////
Route::any('extendemployee', 'UserController@extendemployeeexpiry');
Route::any('changeStatus/{id}', 'PackageController@changeStatus')->name('changeStatus');
Route::any('importpunch', 'HRController@importpunch')->name('importpunch');
Route::any('downloaddemosheet', 'HRController@downloaddemosheet')->name('downloaddemosheet');
Route::any('downloadexcel', 'HRController@downloadexcel')->name('downloadexcel');
Route::any('importemppunchcsv', 'HRController@importemppunchcsv')->name('importemppunchcsv');

Route::any('getpunchrecord', 'HRController@getpunchrecord')->name('getpunchrecord');


Route::any('sessionreportadmin', 'AdminController@sessionreportadmin')->name('sessionreportadmin');
