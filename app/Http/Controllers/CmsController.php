<?php

namespace App\Http\Controllers;

use App\Cms;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function __construct()
{
    $this->middleware('auth');
}


    public function index(Request $request)
    {

 
    }

        public function list(Request $request)
    {

         $data['errortype']='';
         $data['errormsg']='';

                 //unpublish Record

        if($request->has('publish')) 
        {
       $cnt    =   $request->input('count');
       $list   =   array();
       for($i=0;$i<$cnt;$i++){

        if($request->input('chkId'.$i)){
            $list[] =   $request->input('chkId'.$i);
        }
         }
        if(count($list)>0){
         $cmsmodel = new Cms();
         $cmsmodel->publish_records($list);
        $request->session()->flash('msg', 'Selected Items Published!!');
        $request->session()->flash('msgtype', 'success');

        }else{

    $request->session()->flash('msg', 'No Items Selected');
    $request->session()->flash('msgtype', 'warning');
        }   
      return redirect('/cms/list');
       }
   if($request->has('unpublish')) 
        {
       $cnt    =   $request->input('count');
       $list   =   array();
       for($i=0;$i<$cnt;$i++){

        if($request->input('chkId'.$i)){
            $list[] =   $request->input('chkId'.$i);
        }
         }
        if(count($list)>0){
         $cmsmodel = new Cms();
         $cmsmodel->unpublish_records($list);
        $request->session()->flash('msg', 'Selected Items Unpublished!!');
        $request->session()->flash('msgtype', 'warning');

        }else{

    $request->session()->flash('msg', 'No Items Selected');
    $request->session()->flash('msgtype', 'warning');
        }   
      return redirect('/cms/list');
       }

          if($request->has('delete')) 
        {
       $cnt    =   $request->input('count');
       $list   =   array();
       for($i=0;$i<$cnt;$i++){

        if($request->input('chkId'.$i)){
            $list[] =   $request->input('chkId'.$i);
        }
         }
        if(count($list)>0){
         $cmsmodel = new Cms();
         $cmsmodel->delete_records($list);
        $request->session()->flash('msg', 'Selected Items Deleted!!');
        $request->session()->flash('msgtype', 'error');

        }else{

    $request->session()->flash('msg', 'No Items Selected');
    $request->session()->flash('msgtype', 'warning');
        }   
      return redirect('/cms/list');
       }

           if($request->has('updateOrder'))
       {
        $cnt    =   $request->input('count');
        $list   =   array();
      $p  =   0;
    for($i=0;$i<$cnt;$i++){
        $list[$p][0]    =  $request->input('id'.$i);
        $list[$p][1]    =  $request->input('txtOrder'.$i);
        $p++;
         }
        if(count($list)>0){
          $cmsmodel = new Cms();
        $cmsmodel->setorder_records($list);
        $request->session()->flash('msg', 'Selected Items Ordered');
        $request->session()->flash('msgtype', 'success');
        }else{
         $request->session()->flash('msg', 'No Items Selected');
         $request->session()->flash('msgtype', 'warning');
        }   
         return redirect('/cms/list');
       }

        if ($request->session()->has('msg')) {

            $data['errortype']=$request->session()->get('msgtype');
            $data['errormsg']=$request->session()->get('msg');
         }

       $data['currentpage']="cms-list";
       $data['keyword']='';

       if($request->has('keyword')){
        $keyword=$request->input('keyword');
        $data['keyword']=$keyword;
       }else{
        $keyword='';
       }

       //$records= Cms::where('page_id', '!=',0)->paginate(10);

        $query=Cms::select('*');
        $query->where('page_id','!=','');

        if($keyword!=''){
            $query->where('title', 'LIKE', "%{$keyword}%");
            $query->orWhere('page_title','LIKE', "%{$keyword}%");
            }
       $records=$query->paginate(10);

       $data['pages']=$records;



       return view('admin_cms.list', $data);
    }

    public function unpublish_record(Request $request,$id){
   $cmsmodel = new Cms();
   $cmsmodel->unpublish_record($id);
   $request->session()->flash('msg', 'Selected Items Unpublished!!');
   $request->session()->flash('msgtype', 'warning');

    }

    public function publish_record(Request $request,$id){
   $cmsmodel = new Cms();
   $cmsmodel->publish_record($id);
   $request->session()->flash('msg', 'Selected Items Published!!');
   $request->session()->flash('msgtype', 'succcess');
    }

    public function delete_record(Request $request,$id){
   $cmsmodel = new Cms();
   $cmsmodel->delete_record($id);
   $request->session()->flash('msg', 'Selected Items Deleted!!');
   $request->session()->flash('msgtype', 'error');
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
      

        $cms=new Cms;
        $parentList=$cms->get_level_selection();
        $data['parentList']=$parentList;

        $data['currentpage']="cms-create";
        $data['txtMenuTitle']=$request->old('txtMenuTitle');;
        $data['txtParent']=$request->old('txtParent');;
        $data['txtTitle']=$request->old('txtTitle');;
        $data['txtContent']=$request->old('txtContent');;
        $data['seo_keywords']=$request->old('seo_keywords');;
        $data['seo_slug']=$request->old('seo_slug');;
        $data['seo_description']=$request->old('seo_description');;
        $data['seo_title']=$request->old('seo_title');;
        $data['remainingdesccount']='';
        $data['remainingtitlecount']='';

        return view('admin_cms.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->has('submit')) {

        $validatedData = $request->validate([
        'txtMenuTitle' => 'required',
        'txtParent' => 'required',
        'txtTitle' => 'required',
        'txtContent' => 'required',
    ]);


           $txtMenu        =    $request->input('txtMenuTitle');
           $txtParent      =    $request->input('txtParent');
           $txtTitle       =    $request->input('txtTitle');
           $txtContent     =    $request->input('txtContent');
           $seo_title      =    $request->input('seo_title');
           $seo_description=    $request->input('seo_description');
           $seo_keywords   =    $request->input('seo_keywords');
           $seo_slug       =    $request->input('seo_slug');
           $radPublish     =    1;
           $txtPosition    =    1;
           $imagename='';

   
           if ($request->hasFile('txtFile') && $request->file('txtFile')->isValid()) {

            $file = $request->file('txtFile');
   
            $fileorgname      =   $file->getClientOriginalName();
            $fileextension    =   $file->getClientOriginalExtension();
            $filerealpath     =   $file->getRealPath();
            $filesize         =   $file->getSize();
            $filememetype     =   $file->getMimeType();

            $allowedextensions=array('jpg','jpeg','png','bmp','gif');

            if (in_array($fileextension,$allowedextensions)) 
            { 

              $imagename = $request->txtFile->store('uploads');  

              $imagename=str_replace('uploads/','',$imagename);
              $destinationPath = 'uploads';
              $file->move($destinationPath, $imagename);

            }//allowed extension    
    
           }//file submitted

        $cms=new Cms;
        $level=$cms->getLevl($txtParent);
        $order=$cms->getNextOrder($txtParent);
        $txtContent1=addslashes($txtContent);
        $date_update=date("Y-m-d H:i:s");
        if($seo_slug!=''){
            $delimiter="-";
           $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $seo_slug))))), $delimiter));
 
        }else{ 
   
                 $delimiter="-";
           $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $txtMenu))))), $delimiter));
        }
       

        $insertdata = array('order'=>$order,'level'=>$level,'parent'=>$txtParent,'published'=>$radPublish,'title'=>$txtMenu,'page_title'=>$txtTitle,'content'=>$txtContent1,'position'=>$txtPosition,'date_update'=>$date_update,'seo_title'=>$seo_title,'seo_description'=>$seo_description,'seo_keywords'=>$seo_keywords,'seo_slug'=>$seo_slug,'banner'=>$imagename);

        Cms::create($insertdata);

    $request->session()->flash('msg', 'Record Saved Successfully!!');
    $request->session()->flash('msgtype', 'success');


 return redirect('/cms/list');
    
          }//form submitted

   return redirect('/cms/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function show(Cms $cms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        $data['id']=$id;
        $cms=new Cms;
        $parentList=$cms->get_level_selection();
        $data['parentList']=$parentList;
        $record= Cms::where('page_id',$id)->first();
        $data['record']=$record;
        $data['remainingdesccount']='';
        $data['remainingtitlecount']='';

        return view('admin_cms.edit', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
         if($request->has('submit')) {

        $validatedData = $request->validate([
        'txtMenuTitle' => 'required',
        'txtParent' => 'required',
        'txtTitle' => 'required',
        'txtContent' => 'required',
    ]);


           $txtMenu        =    $request->input('txtMenuTitle');
           $txtParent      =    $request->input('txtParent');
           $txtTitle       =    $request->input('txtTitle');
           $txtContent     =    $request->input('txtContent');
           $seo_title      =    $request->input('seo_title');
           $seo_description=    $request->input('seo_description');
           $seo_keywords   =    $request->input('seo_keywords');
           $seo_slug       =    $request->input('seo_slug');
           $radPublish     =    1;
           $txtPosition    =    1;
           $imagename='';

   
           if ($request->hasFile('txtFile') && $request->file('txtFile')->isValid()) {

            $file = $request->file('txtFile');
   
            $fileorgname      =   $file->getClientOriginalName();
            $fileextension    =   $file->getClientOriginalExtension();
            $filerealpath     =   $file->getRealPath();
            $filesize         =   $file->getSize();
            $filememetype     =   $file->getMimeType();

            $allowedextensions=array('jpg','jpeg','png','bmp','gif');

            if (in_array($fileextension,$allowedextensions)) 
            { 

              $imagename = $request->txtFile->store('uploads');  

              $imagename=str_replace('uploads/','',$imagename);
              $destinationPath = 'uploads';
              $file->move($destinationPath, $imagename);
            Cms::where('page_id',$id)->update(array('banner'=>$imagename));
            }//allowed extension    
    
           }//file submitted

        $cms=new Cms;
        $level=$cms->getLevl($txtParent);
        $order=$cms->getNextOrder($txtParent);
        $txtContent1=addslashes($txtContent);
        $date_update=date("Y-m-d H:i:s");
        if($seo_slug!=''){
            $delimiter="-";
           $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $seo_slug))))), $delimiter));
 
        }else{ 
   
                 $delimiter="-";
           $slug = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $txtMenu))))), $delimiter));
        }
       

        $updatedata = array('order'=>$order,'level'=>$level,'parent'=>$txtParent,'published'=>$radPublish,'title'=>$txtMenu,'page_title'=>$txtTitle,'content'=>$txtContent1,'position'=>$txtPosition,'date_update'=>$date_update,'seo_title'=>$seo_title,'seo_description'=>$seo_description,'seo_keywords'=>$seo_keywords,'seo_slug'=>$seo_slug);
      Cms::where('page_id',$id)->update($updatedata);
    $request->session()->flash('msg', 'Record Edited Successfully!!');
    $request->session()->flash('msgtype', 'success');
 return redirect('/cms/list');
    
          }//form submitted

   return redirect('/cms/edit/$id');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cms  $cms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cms $cms)
    {
        //
    }
}
