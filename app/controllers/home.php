<?php
class home{
    public function index(){
        echo 'khánh nè';
    }
    public function detail($id='',$slug=''){
        echo 'id Sản phẩm: ' . $id . '</br>';
        echo 'slug: '.$slug;
    }
}