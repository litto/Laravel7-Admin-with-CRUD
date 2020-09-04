<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Cms extends Model
{
    //

    protected $table = 'cms_pages';

    protected $primaryKey = 'page_id';

    protected $guarded = [];

    public $timestamps = false;



       public function get_level_selection()
        {

       $rec=DB::table('cms_pages')->where('level', 1)->get();

      $rec = json_decode(json_encode($rec), true);
     
         $list      =   array();
         for($i=0;$i<count($rec);$i++){
            $list[$i]["id"] =   $rec[$i]['page_id'];
            $list[$i]["title"]  =   $rec[$i]['title'];
         
            $recc=DB::table('cms_pages')->where([['level', '=', '2'],['parent', '=', $rec[$i]['page_id']],])->get();
            $recc = json_decode(json_encode($recc), true);

            for($j=0;$j<count($recc);$j++){
                $list[$i]["items"][$j]['id']=$recc[$j]['page_id'];
                $list[$i]["items"][$j]['title']=$recc[$j]['title'];     
        
             $reccc=DB::table('cms_pages')->where([['level', '=', '3'],['parent', '=', $recc[$i]['page_id']],])->get();
             $reccc = json_decode(json_encode($reccc), true);


                for($k=0;$k<count($reccc);$k++) {
                    $list[$i]["items"][$j]["items"][$k]['id']       =   $reccc[$k]['page_id'];
                    $list[$i]["items"][$j]["items"][$k]['title']    =   $reccc[$k]['title'];
                }
                unset($reccc);
                
            }
            unset($recc);
        
        }       
        unset($rec);        
        return $list;
       }


        function getLevl($id){
     
        if(empty($id)){
            return 1;
        }else{
              $rec=DB::table('cms_pages')->where('page_id',$id)->get();
              $rec = json_decode(json_encode($rec), true);
              $level  =   $rec[0]['level'];
              return $level+1;
        }
    }

        function getNextOrder($parent){
  
       $order = DB::table('cms_pages')->max('order');

        if($order!=''){
            return $order+1;
        }else{
            return 1;
        }
    }


       public function getallparents(){
          $rec=DB::table('cms_pages')->where('level', 1)->get();
          $rec->toArray();
          return $rec;

       }


      public  function unpublish_records($list){

       for($i=0;$i<count($list);$i++){
         DB::table('cms_pages')->where('page_id', $list[$i])->update(['published' => 0]);

        }
         
    }


     public  function publish_records($list){

       for($i=0;$i<count($list);$i++){
         DB::table('cms_pages')->where('page_id', $list[$i])->update(['published' => 1]);

        }
         
    }

      public  function delete_records($list){

       for($i=0;$i<count($list);$i++){
           DB::table('cms_pages')->where('page_id', '=',$list[$i])->delete();
        }
    }

            public  function setorder_records($list){

       for($i=0;$i<count($list);$i++){
                 DB::table('cms_pages')->where('page_id', $list[$i][0])->update(['order' => $list[$i][1]]);

        }
    }


   public function publish_record($id) {
      
      DB::table('cms_pages')->where('page_id', $id)->update(['published' => 1]);

    }


     public function unpublish_record($id) {

      DB::table('cms_pages')->where('page_id', $id)->update(['published' => 0]);

    }

    public function delete_record($id){
    
           DB::table('cms_pages')->where('page_id', '=',$id)->delete();

    }




}
