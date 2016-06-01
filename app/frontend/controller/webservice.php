<?php
class frontend_controller_webservice extends frontend_db_webservice{
    protected $outputxml,$message;
    public $collection,$retrieve,$id,$action,$img;
    public static $notify = array('plugin' => 'false', 'method' => 'print', 'template'=> '');
    public function __construct(){
        $this->webservice = new frontend_model_webservice();
        $this->outputxml = new magixglobal_model_outputxml();
        $this->dbCatalog = new frontend_db_catalog();
        $this->Catalog = new frontend_model_catalog();
        $this->url = magixcjquery_html_helpersHtml::getUrl();
        if (class_exists('frontend_model_message')) {
            $this->message = new frontend_model_message();
        }
        // GET
        if(magixcjquery_filter_request::isGet('collection')){
            $this->collection = magixcjquery_form_helpersforms::inputClean($_GET['collection']);
        }
        if(magixcjquery_filter_request::isGet('retrieve')){
            $this->retrieve = magixcjquery_form_helpersforms::inputClean($_GET['retrieve']);
        }
        if(magixcjquery_filter_request::isGet('id')){
            $this->id = magixcjquery_form_helpersforms::inputNumeric($_GET['id']);
        }
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        // POST
        if(isset($_FILES['img']["name"])){
            $this->img = magixcjquery_url_clean::rplMagixString($_FILES['img']["name"]);
        }
    }

    /**
     * @return string
     */
    private function setWsAuthKey(){
        return "ZQ88PRJX5VWQHCWE4EE7SQ7HPNX00RAJ";
    }
    // ############## GET
    /**
     * get catalog categories
     */
    private function getCatalogCategories(){
        $data = $this->dbCatalog->fetchCategory(
            array(
                'fetch'  =>  'all'
            )
        );
        $this->outputxml->newStartElement('categories');
        foreach($data as $key){
            $this->outputxml->setElement(
                array(
                    'start'=>'category',
                    'attr'=>array(
                        array(
                            'name'      =>  'id',
                            'content'   =>  $key['idclc']
                        ),
                        array(
                            'name'      =>  'idlang',
                            'content'   =>  $key['idlang']
                        )
                    ),
                    'attrNS'=>array(
                        array(
                            'prefix'    =>  'xlink',
                            'name'      =>  'href',
                            'uri'       =>  $this->url.'/webservice/catalog/categories/'.$key['idclc']
                        )
                    )
                )
            );
        }

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * get catalog categories id
     * @param $id
     */
    private function getCatalogCategory($id)
    {

        $data = $this->dbCatalog->s_category_data($id);

        $dataClean = $this->Catalog->setItemData($data, 0);
        $data_2 = $this->Catalog->fetchSubCategory(
            array(
                'fetch' => 'in_cat',
                'idclc' => $id
            )
        );
        $this->outputxml->newStartElement('category');
        $this->outputxml->setElement(
            array(
                'start' => 'language',
                'attr' => array(
                    array(
                        'name' => 'id',
                        'content' => $dataClean['idlang']
                    )
                )
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id_parent',
                'text' => '0'
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id',
                'text' => $id
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'name',
                'text' => $dataClean['name']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'url',
                'text' => $dataClean['url']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
        $this->outputxml->newStartElement('images');
        if($dataClean['imgSrc']['large'] != null){
            $this->outputxml->setElement(
                array(
                    'start' => 'image',
                    'attrNS' => array(
                        array(
                            'prefix' => 'xlink',
                            'name' => 'href',
                            'uri' => $this->url . $dataClean['imgSrc']['large']
                        )
                    )
                )
            );
        }

        $this->outputxml->newEndElement();
        $this->outputxml->setElement(
            array(
                'start' => 'order',
                'text' => $dataClean['order']
            )
        );
        // Load Subcategories in category
        $this->outputxml->newStartElement('subcategories');
        if($data_2 != null) {
            foreach ($data_2 as $key) {
                $this->outputxml->setElement(
                    array(
                        'start' => 'subcategory',
                        'attrNS' => array(
                            array(
                                'prefix' => 'xlink',
                                'name' => 'href',
                                'uri' => $this->url . '/webservice/catalog/subcategories/' . $key['idcls']
                            )
                        )
                    )
                );
            }
        }
        $this->outputxml->newEndElement();

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }

    /**
     * get catalog categories id
     * @param $id
     */
    private function getCatalogSubCategories($id)
    {

        $data = $this->dbCatalog->s_subcategory_data($id);
        $dataClean = $this->Catalog->setItemData($data, 0);

        $this->outputxml->newStartElement('subcategory');
        $this->outputxml->setElement(
            array(
                'start' => 'id_parent',
                'text' => $dataClean['idparent']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'id',
                'text' => $id
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'name',
                'text' => $dataClean['name']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'url',
                'text' => $dataClean['url']
            )
        );
        $this->outputxml->setElement(
            array(
                'start' => 'description',
                'cData' => $dataClean['content']
            )
        );
        $this->outputxml->newStartElement('images');
        if($dataClean['imgSrc']['large'] != null){
            $this->outputxml->setElement(
                array(
                    'start' => 'image',
                    'attrNS' => array(
                        array(
                            'prefix' => 'xlink',
                            'name' => 'href',
                            'uri' => $this->url . $dataClean['imgSrc']['large']
                        )
                    )
                )
            );
        }

        $this->outputxml->newEndElement();
        $this->outputxml->setElement(
            array(
                'start' => 'order',
                'text' => $dataClean['order']
            )
        );
        $this->outputxml->newEndElement();

        $this->outputxml->newEndElement();
        $this->outputxml->output();
    }
    //########## POST

    /**
     * @param $data
     * @return mixed|SimpleXMLElement
     */
    public function setPostMethod($data){
        switch($data['method']){
            case 'xml':
                return simplexml_load_string($_POST[$data['method']], null, LIBXML_NOCDATA);
                break;
            case 'json':
                return json_decode($_POST[$data['method']]);
                break;
        }
    }

    /**
     * @param bool $debug
     * @return mixed|SimpleXMLElement
     */
    public function getResult($debug = false){
        if($_POST){
            $keyPost = array_keys($_POST);
            if (in_array("json", $keyPost) || in_array("xml", $keyPost)) {
                $parse = $this->setPostMethod(array('method' => $keyPost[0]));
                if (is_object($parse)) {
                    if($debug){
                        print '<pre>';
                        print_r($keyPost).'<br />';
                        print_r($parse);
                        print '</pre>';
                    }else{
                        return $parse;
                    }
                }
            }
        }
    }


    /**
     * Set parse data from XML OR JSON
     * @param $operations
     * @return array
     * @throws Exception
     */
    private function setParse($operations){
        switch($operations['type']){
            case 'catalog':
                if(isset($operations['context'])){
                    if($operations['context'] === 'category'){
                        if($operations['scrud'] === 'create') {
                            $language = parent::fetchLanguage(array('fetch' => 'one', 'iso' => $this->getResult()->{'category'}->{'iso'}));
                            $parse = array(
                                'name'      => $this->getResult()->{'category'}->{'name'},
                                'idlang'    => $language['idlang'],
                                'url'       => magixcjquery_url_clean::rplMagixString(
                                    $this->getResult()->{'category'}->{'name'},
                                    array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                ),
                                'content'   => $this->getResult()->{'category'}->{'description'}
                            );
                        }elseif($operations['scrud'] === 'update'){
                            if(array_key_exists('action',$operations)){
                                switch($operations['action']){
                                    case 'links':
                                        break;
                                }
                            }else{
                                if($this->getResult()->{'category'}->{'url'} != ''){
                                    $url = $this->getResult()->{'category'}->{'url'};
                                }else{
                                    $url = magixcjquery_url_clean::rplMagixString(
                                        $this->getResult()->{'category'}->{'name'},
                                        array('dot' => false, 'ampersand' => 'strict', 'cspec' => '', 'rspec' => '')
                                    );
                                }
                                $parse = array(
                                    'id'        => $this->getResult()->{'category'}->{'id'},
                                    'name'      => $this->getResult()->{'category'}->{'name'},
                                    'url'       => $url,
                                    'content'   => $this->getResult()->{'category'}->{'description'}
                                );
                            }
                        }
                    }
                }
            break;
        }
        return $parse;
    }
    /**
     * @param bool $debug
     * @throws Exception
     */
    public function setPostData($operations,$dataValidate,$debug = false){
        if($debug){
            $this->getResult($debug);
        }else{
            $parse = $this->setParse($operations);
            /**
             * Data validate from POST
             */
            foreach($dataValidate as $input){
                if (!($parse[$input]) OR $parse[$input] == null OR $parse[$input] == ''){
                    $this->message->json_post_response(false,'error',self::$notify,'Params : '.$input.' is not valid');
                    return;
                }else{
                    if($operations['scrud'] === 'create') {
                        parent::insertNewData(array(
                            'type'      => $operations['type'],
                            'context'   => $operations['context'],
                            'name'      => $parse['name'],
                            'url'       => $parse['url'],
                            'content'   => $parse['content'],
                            'idlang'    => $parse['idlang']
                        ));
                        $this->message->json_post_response(true,'success',self::$notify,'Add success');
                    }elseif($operations['scrud'] === 'update'){
                        parent::updateData(array(
                            'type'      => $operations['type'],
                            'context'   => $operations['context'],
                            'id'        => $parse['id'],
                            'name'      => $parse['name'],
                            'url'       => $parse['url'],
                            'content'   => $parse['content']
                        ));
                        $this->message->json_post_response(true,'success',self::$notify,'Update success');
                    }
                    return;
                }
            }
        }
    }
    /**
     * Set catalog
     */
    private function setCatalog(){
        switch ($this->retrieve){
            case 'categories':
                if(isset($this->id)){
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->setPostData(
                                array(
                                    'type'=>'catalog',
                                    'context'=>'category',
                                    'scrud'=>'update'
                                ),
                                array(
                                    'name','url','content'
                                )
                            );
                        }
                    }elseif(isset($this->img)) {
                        if($this->webservice->authorization($this->setWsAuthKey())) {
                            $data = $this->dbCatalog->s_category_data($this->id);
                            $resultUpload = $this->webservice->setUploadImage(
                                'img',
                                array(
                                    'name' => magixglobal_model_cryptrsa::random_generic_ui(),
                                    'edit' => $data['img_c'],
                                    'attr_name' => 'catalog',
                                    'attr_size' => 'category'
                                ),
                                array(
                                    'type' => 'catalog',
                                    'context' => array('category')
                                )
                            );
                            if($resultUpload['statut']){
                                parent::updateData(array(
                                    'type'      => 'catalog',
                                    'context'   => 'category',
                                    'id'        => $this->id,
                                    'img'      => $resultUpload['file']
                                ));
                            }
                            $this->message->json_post_response($resultUpload['statut'], $resultUpload['notify'], self::$notify, $resultUpload['msg']);
                        }
                    }else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogCategory($this->id);
                        }
                    }

                }else{
                    if(isset($_POST['xml']) || isset($_POST['json'])){
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->setPostData(
                                array(
                                    'type'      =>  'catalog',
                                    'context'   =>  'category',
                                    'scrud'     =>  'create'
                                ),
                                array(
                                    'name','idlang','url','content'
                                )
                            );
                        }
                    }/*elseif(isset($this->img)) {
                        $resultUpload = $this->setUploadImage(
                            'img',
                            array(
                                'name'  =>  magixglobal_model_cryptrsa::random_generic_ui(),
                                'edit'  =>  null,
                                'attr_name'  =>  'catalog',
                                'attr_size'  =>  'product'
                            ),
                            array(
                                'type'      =>  'catalog'/*,
                                'context'   =>  'category'*/
                            /*),
                            array(
                                'type'      =>  'catalog',
                                'context'   =>  array('product','medium','mini')
                            )
                        );
                        $this->message->json_post_response($resultUpload['statut'],$resultUpload['notify'],self::$notify,$resultUpload['msg']);
                    }*/else{
                        if($this->webservice->authorization($this->setWsAuthKey())){
                            $this->outputxml->getXmlHeader();
                            $this->getCatalogCategories();
                        }
                    }
                }
                break;
            case 'subcategories':
                if(isset($this->id)){
                    if($this->webservice->authorization($this->setWsAuthKey())){
                        $this->outputxml->getXmlHeader();
                        $this->getCatalogSubCategories($this->id);
                    }
                }
                break;
        }
    }

    /**
     * Execute webservice function
     */
    public function run(){
        if (isset($this->collection)) {
            switch ($this->collection) {
                case 'catalog':
                    $this->setCatalog();
                    break;
            }
        } else {
            /*$curl_params = array();
            $encodedAuth = $this->setWsAuthKey();*/
            /*$options = array(
                CURLOPT_HEADER          => true,
                CURLOPT_RETURNTRANSFER  => true,
                CURLINFO_HEADER_OUT     => true,
                CURLOPT_URL             => 'http://www.magixcms.dev/webservice/catalog/categories',
                CURLOPT_HTTPAUTH        => CURLAUTH_BASIC,
                CURLOPT_USERPWD         => $encodedAuth,
                CURLOPT_HTTPHEADER => array("Authorization : Basic ".$encodedAuth,"Content-Type: text/xml;charset=utf-8")
            );
            $ch = curl_init();
            curl_setopt_array($ch,$options);
            $response = curl_exec($ch);
            //print_r($response);
            $curlInfo = curl_getinfo($ch);
            $index = strpos($response, "\r\n\r\n");
            if ($index === false && $curl_params[CURLOPT_CUSTOMREQUEST] != 'HEAD'){
                throw new Exception('Bad HTTP response');
            }
            $header = substr($response, 0, $index);
            $body = substr($response, $index + 4);
            $headerArrayTmp = explode("\n", $header);
            $headerArray = array();
            foreach ($headerArrayTmp as &$headerItem)
            {
                $tmp = explode(':', $headerItem);
                $tmp = array_map('trim', $tmp);
                if (count($tmp) == 2)
                    $headerArray[$tmp[0]] = $tmp[1];
            }
            curl_close ($ch);
            header('Content-type: text/xml; charset=UTF-8');*/
            /*print '<pre>';
            //print_r($response);
            //print_r($curlInfo);
            print_r(array('status_code' => $curlInfo['http_code'], 'response' => $body, 'header' => $header));
            print '</pre>';*/
            //print $body;
            //if(isset($this->data)){
            //$data_string = "postvar1=value1&postvar2=value2&postvar3=value3";
            /*$data_string = array(
                    'name' => 'test',
                    'content' => 'mon test'
            );*/
            /*$test = $this->outputxml->newStartElement('categories');
            $test .= $this->outputxml->setElement(
                    array(
                        'start'=>'category',
                        'text'=> 'truc'
                    )
                );

            $test .= $this->outputxml->newEndElement();
            $test .= $this->outputxml->output();*/
            /*$test = '<?xml version="1.0" encoding="UTF-8" ?>
        <magixcms>
            <category>
                <iso>fr</iso>
                <name>Mon titre via webservice xml</name>
                <url>mon-url</url>
                <description>
                    <![CDATA[<div id="lipsum">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi. Mauris in augue dui. Nulla accumsan neque at dignissim consequat. In pharetra dignissim lorem, ac aliquet purus varius et. Cras fermentum sit amet elit et varius. Integer dui leo, pretium eget viverra vel, bibendum vel est. Pellentesque commodo, magna sed consequat eleifend, odio ligula venenatis sapien, eget aliquet orci augue ultricies velit. Sed cursus accumsan sapien, at gravida libero dignissim ut. Nulla facilisi. Aliquam augue nunc, suscipit ut elit eget, ullamcorper sagittis arcu.</p>
                    <p>Ut scelerisque, dui eleifend sollicitudin varius, libero ligula consectetur ligula, sit amet tristique dui lorem ut tortor. Nam commodo ipsum quam, eget finibus eros semper malesuada. Curabitur eget pellentesque lacus, et tincidunt dui. Sed congue bibendum purus, et lacinia enim lacinia quis. Proin interdum eu leo ut hendrerit. Nam at maximus risus. Cras nec volutpat est, vel malesuada nisi. Nullam in mi in dolor malesuada ornare. In sed massa massa.</p>
                    </div>]]>
                </description>
            </category>
        </magixcms>';*/
            $test = '<?xml version="1.0" encoding="UTF-8" ?>
        <magixcms>
            <category>
                <id>1</id>
                <name>Mon édition</name>
                <url></url>
                <description>
                    <![CDATA[
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi.</p>]]>
                </description>
            </category>
        </magixcms>';
            $description = '<div id="lipsum">
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam felis ex, blandit accumsan risus quis, eleifend mollis nisi. Mauris in augue dui. Nulla accumsan neque at dignissim consequat. In pharetra dignissim lorem, ac aliquet purus varius et. Cras fermentum sit amet elit et varius. Integer dui leo, pretium eget viverra vel, bibendum vel est. Pellentesque commodo, magna sed consequat eleifend, odio ligula venenatis sapien, eget aliquet orci augue ultricies velit. Sed cursus accumsan sapien, at gravida libero dignissim ut. Nulla facilisi. Aliquam augue nunc, suscipit ut elit eget, ullamcorper sagittis arcu.</p>
                    <p>Ut scelerisque, dui eleifend sollicitudin varius, libero ligula consectetur ligula, sit amet tristique dui lorem ut tortor. Nam commodo ipsum quam, eget finibus eros semper malesuada. Curabitur eget pellentesque lacus, et tincidunt dui. Sed congue bibendum purus, et lacinia enim lacinia quis. Proin interdum eu leo ut hendrerit. Nam at maximus risus. Cras nec volutpat est, vel malesuada nisi. Nullam in mi in dolor malesuada ornare. In sed massa massa.</p>
                    </div>';
            $json = json_encode(array('category'=>array(
                'id'            =>  1,
                'name'          =>  'Mon titre via webservice json',
                'url'           =>  '',
                'description'   => $description
            )));

            print $this->webservice->setPreparePostData(array(
                'wsAuthKey'=>$this->setWsAuthKey(),
                'method' => 'xml',
                'request' => $test,
                'url' => 'http://www.magixcms.dev/webservice/catalog/categories/1'
            ));

            
            /*print $this->webservice->setPreparePostImg(array(
                'wsAuthKey' =>  $this->setWsAuthKey(),
                'url'       => 'http://www.magixcms.dev/webservice/catalog/categories/3'
            ));*/
        }
    }
}