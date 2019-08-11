<?php
namespace App\Traits;
use Modules\Gduss\Entities\Permit;
use Modules\Gduss\Entities\Car;
use Modules\Gduss\Entities\Person;
use Modules\Gduss\Entities\GdussFiles;
use Carbon\Carbon;

trait Gduss
{

  public function plateKSA($plate){
    $plate = $plate['l1'] .' '. $plate['l2'] .' '. $plate['l3'] .' '. $plate['n1'] .' '. $plate['n2'] .' '. $plate['n3'] .' '. $plate['n4'] ;
    return $plate ;
  }
  // add all file in Premit
  public function addFiles($idPremit,$files){
     // dd($idPremit);
    foreach ($files as $key => $value) {
      $f = new GdussFiles;
      $f->permit_id = $idPremit;
      $f->type = $key;
        $destinationPath = public_path('uploads/gduss');
        $file = $files[$key];
        $extension = $file->getClientOriginalExtension();
        $fileName = uniqid().'.'. new carbon .'.'.$extension;
        $file->move($destinationPath, $fileName);
      $f->file = $fileName;
      $f->save();
    }
    return ;
  }

  public function checkPremit($numPremit,$category){
    $inPremit = Permit::where('permit_no', $numPremit)
                      ->where('category', $category)
                      ->count();
    if($inPremit == 0){
      return $inPremit = false;
    }elseif($inPremit != 0){
      return $inPremit = true;
    }
  }

  public function checkCar($plate){
    $inPremit = Car::where('plate', $plate)
                      ->where('allowable', 0)
                      ->count();
    if($inPremit == 0){
      return $inPremit = false;
    }elseif($inPremit != 0){
      return $inPremit = true;
    }
  }
  //إنشاء الشخص
  public function addPerson($user,$additional,$user_type){
    //dd($user_type);
    if ($user_type == 1){
      $nid = $user->national_id ;
    }elseif($user_type == 2){
      $nid = $user->user_idno ;
    }elseif($user_type == 3){
      $nid = $user['nid'];
    }
    $inPerson = Person::where('nid', '=', $nid)->first();
    if($inPerson == NULL){
      $person = $this->personData($additional,$user,$user_type);
      $inPerson = Person::create($person);
    }else{
      $updata = Person::find($inPerson->id);
      $updata['street'] = $additional['street'];
      $updata['job_contract'] = $additional['job_contract'];
      $updata['authority'] = $additional['authority'];
      $updata['domicile'] = $additional['domicile'];
      $updata['district'] = $additional['district'];
      $updata['relative'] = $additional['relative'];
      $updata['rel_realation'] = $additional['rel_realation'];
      $updata['rel_mob'] = $additional['rel_mob'];
      $updata->save();
    }
    return $inPerson->id;
  }
   // إنشاء المركبة
  // public function addCar($data,$person_id){
  //   $car = $data['car'];
  //   $car['person_id'] = $person_id;
  //   $car['owner'] = $data['owner'];
  //   $car = Car::create($car);
  //   return $car->id;
  // }
  //إنشاء التصريح
 public function addPermit($data,$person_id,$car_id){
   $premit = $data['user'];
   $premit['person_id'] = $person_id;
   $premit['car_id'] = $car_id;
   $permit = Permit::create($premit);
   return $permit ->id;
 }
 public function personData($additional,$user,$user_type){
   //dd($user);
   $person = $additional;
   if($user_type == 1){
     $person['name'] = $user->arabic_name;
     $person['nid'] = $user->national_id;
     $person['jobtitle'] = $user->job_desc;
     $person['grade'] = $user->scale_desc;
     $person['empid'] = $user->job_no;
     $person['mobile'] = $user->mobile_no;
     $person['employer'] = $user->actual_dept_code_desc;
   }elseif($user_type == 2){
     $person['name'] = $user->user_name;
     $person['nid'] = $user->user_idno;
     $person['jobtitle'] = $user->user_desc;
     $person['grade'] = NULL;
     $person['empid'] = $user->user_empno;
     $person['mobile'] = $user->user_mobile;
     $person['employer'] = NULL;
   }elseif($user_type == 3){
     $person['name'] = $user['name'];
     $person['nid'] = $user['nid'];
     $person['jobtitle'] = $user['jobtitle'];
     $person['grade'] = $user['grade'];
     $person['empid'] = $user['empid'];
     $person['mobile'] = $user['mobile'];
     $person['employer'] = $user['employer'];
   }
   return $person;
 }
 public function plateAvailable($plate){
   $inCars = Car::where('plate', '=', $plate)
                   ->Where('allowable','=',0)
                   ->first();
    return $inCars;
 }
}
