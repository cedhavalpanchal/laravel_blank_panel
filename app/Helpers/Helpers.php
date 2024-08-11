<?php

if (!function_exists('theme')) {
    function theme()
    {
        return app(App\Core\Theme::class);
    }
}

if (!function_exists('getName')) {
    /**
     * Get product name
     *
     * @return void
     */
    function getName()
    {
        return config('settings.KT_THEME');
    }
}


if (!function_exists('addHtmlAttribute')) {
    /**
     * Add HTML attributes by scope
     *
     * @param $scope
     * @param $name
     * @param $value
     *
     * @return void
     */
    function addHtmlAttribute($scope, $name, $value)
    {
        theme()->addHtmlAttribute($scope, $name, $value);
    }
}


if (!function_exists('addHtmlAttributes')) {
    /**
     * Add multiple HTML attributes by scope
     *
     * @param $scope
     * @param $attributes
     *
     * @return void
     */
    function addHtmlAttributes($scope, $attributes)
    {
        theme()->addHtmlAttributes($scope, $attributes);
    }
}


if (!function_exists('addHtmlClass')) {
    /**
     * Add HTML class by scope
     *
     * @param $scope
     * @param $value
     *
     * @return void
     */
    function addHtmlClass($scope, $value)
    {
        theme()->addHtmlClass($scope, $value);
    }
}


if (!function_exists('printHtmlAttributes')) {
    /**
     * Print HTML attributes for the HTML template
     *
     * @param $scope
     *
     * @return string
     */
    function printHtmlAttributes($scope)
    {
        return theme()->printHtmlAttributes($scope);
    }
}


if (!function_exists('printHtmlClasses')) {
    /**
     * Print HTML classes for the HTML template
     *
     * @param $scope
     * @param $full
     *
     * @return string
     */
    function printHtmlClasses($scope, $full = true)
    {
        return theme()->printHtmlClasses($scope, $full);
    }
}


if (!function_exists('getSvgIcon')) {
    /**
     * Get SVG icon content
     *
     * @param $path
     * @param $classNames
     * @param $folder
     *
     * @return string
     */
    function getSvgIcon($path, $classNames = 'svg-icon', $folder = 'assets/media/icons/')
    {
        return theme()->getSvgIcon($path, $classNames, $folder);
    }
}


if (!function_exists('setModeSwitch')) {
    /**
     * Set dark mode enabled status
     *
     * @param $flag
     *
     * @return void
     */
    function setModeSwitch($flag)
    {
    }
}


if (!function_exists('isModeSwitchEnabled')) {
    /**
     * Check dark mode status
     *
     * @return void
     */
    function isModeSwitchEnabled()
    {
    }
}


if (!function_exists('setModeDefault')) {
    /**
     * Set the mode to dark or light
     *
     * @param $mode
     *
     * @return void
     */
    function setModeDefault($mode)
    {
    }
}


if (!function_exists('getModeDefault')) {
    /**
     * Get current mode
     *
     * @return void
     */
    function getModeDefault()
    {
    }
}


if (!function_exists('setDirection')) {
    /**
     * Set style direction
     *
     * @param $direction
     *
     * @return void
     */
    function setDirection($direction)
    {
    }
}


if (!function_exists('getDirection')) {
    /**
     * Get style direction
     *
     * @return void
     */
    function getDirection()
    {
    }
}


if (!function_exists('isRtlDirection')) {
    /**
     * Check if style direction is RTL
     *
     * @return void
     */
    function isRtlDirection()
    {
    }
}


if (!function_exists('extendCssFilename')) {
    /**
     * Extend CSS file name with RTL or dark mode
     *
     * @param $path
     *
     * @return void
     */
    function extendCssFilename($path)
    {
    }
}


if (!function_exists('includeFavicon')) {
    /**
     * Include favicon from settings
     *
     * @return string
     */
    function includeFavicon()
    {
        return theme()->includeFavicon();
    }
}


if (!function_exists('includeFonts')) {
    /**
     * Include the fonts from settings
     *
     * @return string
     */
    function includeFonts()
    {
        return theme()->includeFonts();
    }
}


if (!function_exists('getGlobalAssets')) {
    /**
     * Get the global assets
     *
     * @param $type
     *
     * @return array
     */
    function getGlobalAssets($type = 'js')
    {
        return theme()->getGlobalAssets($type);
    }
}


if (!function_exists('addVendors')) {
    /**
     * Add multiple vendors to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendors
     *
     * @return void
     */
    function addVendors($vendors)
    {
        theme()->addVendors($vendors);
    }
}


if (!function_exists('addVendor')) {
    /**
     * Add single vendor to the page by name. Refer to settings KT_THEME_VENDORS
     *
     * @param $vendor
     *
     * @return void
     */
    function addVendor($vendor)
    {
        theme()->addVendor($vendor);
    }
}


if (!function_exists('addJavascriptFile')) {
    /**
     * Add custom javascript file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addJavascriptFile($file)
    {
        theme()->addJavascriptFile($file);
    }
}


if (!function_exists('addCssFile')) {
    /**
     * Add custom CSS file to the page
     *
     * @param $file
     *
     * @return void
     */
    function addCssFile($file)
    {
        theme()->addCssFile($file);
    }
}


if (!function_exists('getVendors')) {
    /**
     * Get vendor files from settings. Refer to settings KT_THEME_VENDORS
     *
     * @param $type
     *
     * @return array
     */
    function getVendors($type)
    {
        return theme()->getVendors($type);
    }
}


if (!function_exists('getCustomJs')) {
    /**
     * Get custom js files from the settings
     *
     * @return array
     */
    function getCustomJs()
    {
        return theme()->getCustomJs();
    }
}


if (!function_exists('getCustomCss')) {
    /**
     * Get custom css files from the settings
     *
     * @return array
     */
    function getCustomCss()
    {
        return theme()->getCustomCss();
    }
}


if (!function_exists('getHtmlAttribute')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $scope
     * @param $attribute
     *
     * @return array
     */
    function getHtmlAttribute($scope, $attribute)
    {
        return theme()->getHtmlAttribute($scope, $attribute);
    }
}

if (!function_exists('isUrl')) {
    /**
     * Get HTML attribute based on the scope
     *
     * @param $url
     *
     * @return mixed
     */
    function isUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}

if (!function_exists('image')) {
    /**
     * Get image url by path
     *
     * @param $path
     *
     * @return string
     */
    function image($path)
    {
        return asset('assets/media/'.$path);
    }
}


/* Api Helpers  */

    function sendResponse($result, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $result,
            'message' => $message,
        ];


        return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    function sendError($error, $code = 404, $errorMessages = [])
    {
    	$response = [
            'status' => false,
            'code' => $code,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    function sendApiResponse($result)
    {
    	$response = [
            'status' => $result['status'],
            'code' => $result['code'], 
            'message' => $result['message'],
            'data'    => $result['data'],
        ];

        return response()->json($response, 200);
    }

    // check prep owner
    if (!function_exists('checkPrepOwner')) {
        function checkPrepOwner($data)
        {
            if(strtolower($data) == 'amazon' ){
                $res = 0;
            } else {
                $res = 1; // seller
            }

            return $res;
        }
    }

    // check owner label value
    if (!function_exists('checkOwnerLabel')) {
        function checkOwnerLabel($data)
        {
            if(strtolower($data) == strtolower('AMAZON_LABEL_ONLY') ){
                $res = 0;   // AMAZON_LABEL_ONLY
            } elseif(strtolower($data) == strtolower('SELLER_LABEL') ){
                $res = 1;   // SELLER_LABEL
            } else {
                $res = 2; // AMAZON_LABEL_PREFERRED
            }
            return $res;
        }
    }

    // check prep info
    if (!function_exists('checkPrepInfo')) {
        function checkPrepInfo($data)
        {
            if(strtolower($data) == 'none'){
                $res = 0;   // none
            } elseif (strtolower($data) ==  'noPrep'){
                $res = 1;   // noPrep
            } elseif (strtolower($data) == 'polybagging') {
                $res = 2;   // polybagging
            } elseif (strtolower($data) == 'bubbleWrapping') {
                $res = 3;   // bubbleWrapping
            } elseif (strtolower($data) == 'taping') {
                $res = 4;   // taping
            } elseif (strtolower($data) == 'blackShrinkWrapping') {
                $res = 5;   // blackShrinkWrapping
            } elseif (strtolower($data) == 'labeling') {
                $res = 6;   // labeling
            } elseif (strtolower($data) == 'hangGarment') {
                $res = 7;   // hangGarment
            } elseif (strtolower($data) == 'setCreation') {
                $res = 8;   // setCreation
            } elseif (strtolower($data) == 'boxing') {
                $res = 9;   // boxing
            } elseif (strtolower($data) == 'removeFromHanger') {
                $res = 10;   // removeFromHanger
            } elseif (strtolower($data) == 'debundle') {
                $res = 11;   // debundle
            } elseif (strtolower($data) == 'suffocationStickering') {
                $res = 12;   // suffocationStickering
            } elseif (strtolower($data) == 'capSealing') {
                $res = 13;   // capSealing
            } elseif (strtolower($data) == 'setStickering') {
                $res = 14;   // setStickering
            } elseif (strtolower($data) == 'blankStickering') {
                $res = 15;   // blankStickering
            } elseif (strtolower($data) == 'shipsInProductPackaging') {
                $res = 16;   // shipsInProductPackaging
            } else {
                $res = 0;   // none (while null value)
            }

            return $res;
        }
    }

    // Convert prep owner
    if (!function_exists('convertPrepOwner')) {
        function convertPrepOwner($data)
        {
            if(strtolower($data) == '0' ){
                $res = 'AMAZON';
            } else {
                $res = 'SELLER'; // 1
            }

            return $res;
        }
    }

    // convert Owner Label
    if (!function_exists('convertOwnerLabel')) {
        function convertOwnerLabel($data)
        {
            if(strtolower($data) == 0 ){
                $res = 'AMAZON_LABEL_ONLY';   // AMAZON_LABEL_ONLY
            } elseif(strtolower($data) == 2 ){
                $res = 'AMAZON_LABEL_PREFERRED'; // 2 - AMAZON_LABEL_PREFERRED
            } else {
                $res = 'SELLER_LABEL';   // SELLER_LABEL
            }
            return $res;
        }
    }

    // Convert prep Info
    if (!function_exists('convertPrepInfo')) {
        function convertPrepInfo($data)
        {
            if(strtolower($data) == 0 ){
                $res = 'NONE';
            } elseif ($data == 1 ){
                $res = 'NoPrep';
            } elseif ($data == 2 ) {
                $res = 'Polybagging';
            } elseif ($data == 3 ) {
                $res = 'BubbleWrapping';
            } elseif ($data == 4 ) {
                $res = 'Taping';
            } elseif ($data == 5 ) {
                $res = 'BlackShrinkWrapping';
            } elseif ($data == 6 ) {
                $res = 'Labeling';
            } elseif ($data == 7 ) {
                $res = 'HangGarment';
            } elseif ($data == 8 ) {
                $res = 'SetCreation';
            } elseif ($data == 9 ) {
                $res = 'Boxing';
            } elseif ($data == 10 ) {
                $res = 'RemoveFromHanger';
            } elseif ($data == 11 ) {
                $res = 'Debundle';
            } elseif ($data == 12 ) {
                $res = 'SuffocationStickering';
            } elseif ($data == 13 ) {
                $res = 'CapSealing';
            } elseif ($data == 14 ) {
                $res = 'SetStickering';
            } elseif ($data == 15 ) {
                $res = 'BlankStickering';
            } elseif ($data == 16 ) {
                $res = 'ShipsInProductPackaging';
            }else{
                $res = 'NONE';
            }

            return $res;
        }
    }

    // date formate
    if (!function_exists('customDate')) {
        function customDate($data)
        {
            return (isset($data) && $data != null) ? date('Y-m-d H:i:s', strtotime($data)) : null;
        }
    }

    // For database date formate
    if (!function_exists('customDateDatabase')) {
        function customDateDatabase($data)
        {
            return (isset($data) && $data != null) ? date('y-m-d h:i:s', strtotime($data)) : null;
        }
    }

    // check prep owner
    if (!function_exists('customEncrypt')) {
        function customEncrypt($data)
        {

            $key = env('ENCRYPTION_KEY');
            $iv = $iv = env('IV'); //openssl_random_pseudo_bytes(16);
            $cipherText = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);
            return base64_encode($cipherText);
        }
    }

    // check prep owner
    if (!function_exists('customDecrypt')) {
        function customDecrypt($data)
        {
            $key = env('ENCRYPTION_KEY');
            $iv = env('IV'); //openssl_random_pseudo_bytes(16);
            $cipherText = base64_decode($data);
            return openssl_decrypt($cipherText, 'aes-256-cbc', $key, 0, $iv);
        }
    }
    
    // Convert Shipment status Number to String
    if (!function_exists('convertShipmentStatusNumberToString')) {
        function convertShipmentStatusNumberToString($data)
        {
            if(strtolower($data) == 1 ){
                $res = 'WORKING';   // WORKING
            } elseif (strtolower($data) == 2 ){
                $res = 'SHIPPED';   // Bubble SHIPPED
            } elseif (strtolower($data) == 3 ){
                $res = 'RECEIVING';   // Bubble RECEIVING
            } elseif (strtolower($data) == 4 ){
                $res = 'CANCELLED';   // Bubble CANCELLED
            } elseif (strtolower($data) == 5 ){
                $res = 'DELETED';   // Bubble DELETED
            } elseif (strtolower($data) == 6 ){
                $res = 'CLOSED';   // Bubble CLOSED
            } elseif (strtolower($data) == 7 ){
                $res = 'ERROR';   // Bubble ERROR
            } elseif (strtolower($data) == 8 ){
                $res = 'IN_TRANSIT';   // IN_TRANSIT
            } elseif (strtolower($data) == 9 ){
                $res = 'DELIVERED';   // Black Shrink DELIVERED
            } elseif (strtolower($data) == 10 ){
                $res = 'CHECKED_IN';   // CHECKED_IN
            } else {
                $res = 'PENDING'; // 0
            }

            return $res;
        }
    }

    if (!function_exists('convertShipmentStatusStringToNumberCapital')) {
        function convertShipmentStatusStringToNumberCapital($data)
        {
            if($data == 'WORKING' ){

                $res = 1;   // WORKING
            } elseif ($data == 'SHIPPED'){
                $res = 2;   // Bubble SHIPPED
            } elseif ($data == 'RECEIVING'){
                $res = 3;   // Bubble RECEIVING
            } elseif ($data == 'CANCELLED'){
                $res = 4;   // Bubble CANCELLED
            } elseif ($data == 'DELETED'){
                $res = 5;   // Bubble DELETED
            } elseif ($data == 'CLOSED'){
                $res = 6;   // Bubble CLOSED
            } elseif ($data == 'ERROR'){
                $res = 7;   // Bubble ERROR
            } elseif ($data == 'IN_TRANSIT'){
                $res = 8;   // IN_TRANSIT
            } elseif ($data == 'DELIVERED'){
                $res = 9;   // Black Shrink DELIVERED
            } elseif ($data == 'CHECKED_IN'){
                $res = 10;   // CHECKED_IN
            } else {
                $res = 0; // "PENDING"
            }

            return $res;
        }
    }

    // Convert Shipment status Number to String
    if (!function_exists('convertShipmentStatusStringToNumber')) {
        function convertShipmentStatusStringToNumber($data)
        {
            if(strtolower($data) == 'working' ){
                $res = 1;   // WORKING
            } elseif (strtolower($data) == 'shipped' ){
                $res = 2;   // Bubble SHIPPED
            } elseif (strtolower($data) == 'receiving' ){
                $res = 3;   // Bubble RECEIVING
            } elseif (strtolower($data) == 'cancelled' ){
                $res = 4;   // Bubble CANCELLED
            } elseif (strtolower($data) == 'deleted' ){
                $res = 5;   // Bubble DELETED
            } elseif (strtolower($data) == 'closed' ){
                $res = 6;   // Bubble CLOSED
            } elseif (strtolower($data) == 'error' ){
                $res = 7;   // Bubble ERROR
            } elseif (strtolower($data) == 'in_transit' ){
                $res = 8;   // IN_TRANSIT
            } elseif (strtolower($data) == 'delivered' ){
                $res = 9;   // Black Shrink DELIVERED
            } elseif (strtolower($data) == 'checked_in' ){
                $res = 10;   // CHECKED_IN
            } else {
                $res = 0; // pending
            }

            return $res;
            
        }
    }

    // Convert label page type from string to number 
    if (!function_exists('convertLabelPageTypeStringToNumber')) {
        function convertLabelPageTypeStringToNumber($data)
        {
            if(strtolower($data) == 'packagelabel_letter_6' ){
                $res = 1;
            } elseif (strtolower($data) == 'packagelabel_letter_2' ){
                $res = 2;
            } elseif (strtolower($data) == 'packagelabel_letter_4' ){
                $res = 3;
            } elseif (strtolower($data) == 'packagelabel_letter_6_carrierleft' ){
                $res = 4;
            } elseif (strtolower($data) == 'packagelabel_a4_2' ){
                $res = 5;
            } elseif (strtolower($data) == 'packagelabel_a4_4' ){
                $res = 6;
            } elseif (strtolower($data) == 'packagelabel_plain_paper' ){
                $res = 7;
            } elseif (strtolower($data) == 'packagelabel_plain_paper_carrierbottom' ){
                $res = 8;
            } elseif (strtolower($data) == 'packagelabel_thermal' ){
                $res = 9;
            } elseif (strtolower($data) == 'packagelabel_thermal_unified' ){
                $res = 10;
            } elseif (strtolower($data) == 'packagelabel_thermal_nonpcp' ){
                $res = 11;
            } elseif (strtolower($data) == 'packagelabel_thermal_no_carrier_rotation' ){
                $res = 12;
            }else{
                $res = 1;
            }

            return $res;
            
        }
    }

    // Convert label page type from number to string
    if (!function_exists('convertLabelPageTypeNumberToString')) {
        function convertLabelPageTypeNumberToString($data)
        {
            if($data == 1 ){
                $res = 'PackageLabel_Letter_6';
            } elseif ($data == 2 ){
                $res = 'PackageLabel_Letter_2';
            } elseif ($data == 3 ){
                $res = 'PackageLabel_Letter_4';
            } elseif ($data == 4 ){
                $res = 'PackageLabel_Letter_6_CarrierLeft';
            } elseif ($data == 5 ){
                $res = 'PackageLabel_A4_2';
            } elseif ($data == 6 ){
                $res = 'PackageLabel_A4_4';
            } elseif ($data == 7 ){
                $res = 'PackageLabel_Plain_Paper';
            } elseif ($data == 8 ){
                $res = 'PackageLabel_Plain_Paper_CarrierBottom';
            } elseif ($data == 9 ){
                $res = 'PackageLabel_Thermal';
            } elseif ($data == 10 ){
                $res = 'PackageLabel_Thermal_Unified';
            } elseif ($data == 11 ){
                $res = 'PackageLabel_Thermal_NonPCP';
            } elseif ($data == 12 ){
                $res = 'PackageLabel_Thermal_No_Carrier_Rotation';
            }else{
                $res = 'PackageLabel_Letter_6';
            }

            return $res;
            
        }
    }

    // Convert feed status from string to number 
    if (!function_exists('convertFeedTypeStringToNumber')) {
        function convertFeedTypeStringToNumber($data)
        {
            $res= NULL;

            if(strtolower($data) == 'done' ){
                $res = 1;
            } elseif (strtolower($data) == 'in_progress' ){
                $res = 2;
            } elseif (strtolower($data) == 'in_queue' ){
                $res = 3;
            } elseif (strtolower($data) == 'cancelled' ){
                $res = 4;
            } elseif (strtolower($data) == 'fatal' ){
                $res = 5;
            }
            return $res;
        }
    }

    // Convert feed status from number to string
    if (!function_exists('convertFeedTypeNumberToString')) {
        function convertFeedTypeNumberToString($data)
        {
            $res= NULL;

            if($data == 1 ){
                $res = 'DONE';
            } elseif ($data == 2 ){
                $res = 'IN_PROGRESS';
            } elseif ($data == 3 ){
                $res = 'IN_QUEUE';
            } elseif ($data == 4 ){
                $res = 'CANCELLED';
            } elseif ($data == 5 ){
                $res = 'FATAL';
            }
            return $res;
        }
    }