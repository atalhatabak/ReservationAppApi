<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Region;
use App\Models\City;
use App\Models\Branch;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Car;


class UserController extends Controller
{
    public function getBranchs(Request $request)
    {
        
        $branches = Branch::select('branches.id','branches.branch', 'cities.city', 'regions.region')
            ->join('cities', 'branches.city_id', '=', 'cities.id')
            ->join('regions', 'branches.region_id', '=', 'regions.id')
            ->get();
        $cities = City::select( 'cities.city',  'regions.region')
            ->join('regions', 'cities.region_id', '=', 'regions.id')
            ->get();
        $regions = Region::pluck('region');

        $data=[$branches,$cities,$regions];
        return response()->json(['message' => $data]);
    }

    public function getAvaibleDates(Request $request)
    {

        $branch_id=$request->branch_id;

        $aylar = array(1 => "Ocak",2 => "Şubat",3 => "Mart",4 => "Nisan",5 => "Mayıs",6 => "Haziran",7 => "Temmuz",8 => "Ağustos",9 => "Eylül",10 => "Ekim",11 => "Kasım",12 => "Aralık");
        $gunler = array("Pazar","Pazartesi","Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi");
        $sessions = array("08.00","10.00","12.00","14.00","16.00");
        

        $year=date("Y");
        $month=date("n"); // bu ayın numara olarak karşılığı, örn->1
        $day=date("d");

        function haftaninGunu($tarih) { // içerisine tarih giriyor ve o tarihin hangi olduğunu dönderiyor.
            $haftaninGunu = date('w', strtotime($tarih));
            return $haftaninGunu;
        }
        
        $data = []; 
        for($i = $month; $i<=6; $i++){
            $data[$aylar[$i]] = [];
            for($e = 1; $e <= cal_days_in_month(CAL_GREGORIAN, $i, date('Y')); $e++){ // seçili ayın gün sayısı kadar dönen bir döngü $e = gün 
                $sunData=date('Y')."-$i-$e";
                if(haftaninGunu($sunData) != 0){ // Gün Pazar mı kontrol ediliyor, pazarsa eklenmiyor
                    $data[$aylar[$i]][$e." ".$gunler[haftaninGunu($sunData)]] = []; // gün ekleniyor içerisine seanslar eklenecek

                    foreach ($sessions as $session){ // sessions dizisini dönderiyor
                        $reservations=Reservation::where('branch_id',$branch_id)->where('date',"$e.$i.2024")->where('session',"$session")->first(); // dönen tarih seans ve branch e göre databaseden filtreleme yapıyor
                        if(!$reservations  ){ // eğer o günün o saatine rezervasyon yoksa o seansı ekliyor
                            array_push($data[$aylar[$i]][$e." ".$gunler[haftaninGunu($sunData)]], "$session");
                        }
                        else{
                            if($reservations['status'] == "deactive"){
                                array_push($data[$aylar[$i]][$e." ".$gunler[haftaninGunu($sunData)]], $session);
                            }
                        }

                    }
                }

            }
        } // $data dizisine bu aydan itibaren önümüzdeki 6 ay ve her ayın numara olarak günleri eklendi örn 'Ocak':['1','2','3'...]... 

        array_splice($data["Şubat"], 0, $day-1); // bu ayın ilk gününden bugüne kadar olan günler silindi
        return response()->json(['message' => $data  ]);
    }

    public function getCars(Request $request)
    {
        $user_id = Auth::user()->id;
        $cars = Car::where('user_id', $user_id)->select('id','brand', 'model','plaka','owner')->get();
        
        return response()->json(['message' => $cars]);
    }




    public function getReservations(Request $request)
    {
        $user_id = Auth::user()->id;


        $reservations["active"] = Reservation::select('reservations.id','reservations.date','reservations.session','branches.branch','branches.address','cities.city','cars.brand','cars.model','reservations.report','reservations.status')
            ->join('cars','reservations.car_id', '=', 'cars.id')
            ->join('branches','reservations.branch_id', '=', 'branches.id')
            ->join('cities', 'branches.city_id', '=', 'cities.id')
            ->where('reservations.user_id', $user_id) // Sadece user_id değeri 1 olanları filtrele
            ->where('status',"active")
            ->get();
        $reservations["deactive"] = Reservation::select('reservations.id','reservations.date','reservations.session','branches.branch','branches.address','cities.city','cars.brand','cars.model','reservations.report','reservations.status')
            ->join('cars','reservations.car_id', '=', 'cars.id')
            ->join('branches','reservations.branch_id', '=', 'branches.id')
            ->join('cities', 'branches.city_id', '=', 'cities.id')
            ->where('reservations.user_id', $user_id) // Sadece user_id değeri 1 olanları filtrele
            ->where('status',"deactive")
            ->get();

        $data = $reservations;
        return response()->json(['message' => $data]);
    }

    public function addCar(Request $request)
    {
        try{
            $validate = Validator::make($request->all(), 
            [
                'brand' => 'required',
                'model' => 'required',
                'plaka' => 'required',
                'owner' => 'required',
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Eksik Bilgi',
                    'errors' => $validateUser->errors()
                ], 401);
            }
    
            $car= Car::create([
                'brand' => $request->brand,
                'model' => $request->model,
                'plaka' => $request->plaka,
                'owner' => $request->owner,
                'user_id' => Auth::user()->id,
            ]);
            return response()->json([
                'status' => true,
                'message' => 'Araç Eklendi',
             ], 200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }        
    }

    public function addReservation(Request $request)
    {
        $user_id = Auth::user()->id;

        try{
            $validate = Validator::make($request->all(), 
            [
                'date' => 'required',
                'session' => 'required',
                'branch_id' => 'required',
                'car_id' => 'required',
            ]);
    
            if($validate->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Eksik Bilgi',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            // Şubat-2 Cuma-2024 bu şekilde gelen veri 2.2.2024 bu şekilde olacak şekilde güncelleniyor
            $aylar = array(1 => "Ocak",2 => "Şubat",3 => "Mart",4 => "Nisan",5 => "Mayıs",6 => "Haziran",7 => "Temmuz",8 => "Ağustos",9 => "Eylül",10 => "Ekim",11 => "Kasım",12 => "Aralık");

            //Ocak-31 Çarşamba-2024


            $date=$request->date;
            $date=explode('-',$date);
            $day=$date[1];
            $day=explode(' ',$day);
            $day=$day[0];
            $month=$date[0];
            $month = array_search(ucfirst(strtolower($month)), $aylar);
            $year=$date[2];
            $date="$day.$month.$year";


            $car= Reservation::create([
                'date' => $date,
                'session' => $request->session,
                'user_id' => Auth::user()->id,
                'branch_id' => $request->branch_id,
                'car_id' => $request->car_id,

            ]);
            return response()->json([
                'status' => true,
                'message' => 'Rezervasyon Oluşturuldu',
             ], 200);
        }
        catch(\Throwable $th){
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }    
        
        
    }

    public function deleteReservation(Request $request)
        {
            $id=$request->id;
            $reservation = Reservation::find($id);
            if($reservation){
                $reservation->update(['status'=>'deactive']);
            }
            
            return response()->json(['message' => "Başarılı"]);
        }

    public function getPersonalInfo(Request $request)
        {
            $user_id = Auth::user()->id;
            $user=User::Where('id' , 1)->select('name','TC','phone','email')->get();
            
            return response()->json(['message' => $user]);
        }

    public function updatePersonalInfo(Request $request)
        {
            $user_id = Auth::user()->id;

            $user = User::find($user_id);
            $updateData = [
                'name' => request('name'),
                'TC' => request('TC'),
                'phone' => request('phone'),
                'email' => request('email'),
            ];
            if (request('password')) { // eğer şifre gönderilmişse güncelleniyor, boş ise güncellenmiyor
                $updateData['password'] = Hash::make(request('password'));
            }

            if ($user) {
                $user->update($updateData);
                return response()->json(['message' => 'Kullanıcı başarıyla güncellendi']);
            } else {
                return response()->json(['error' => 'Kullanıcı bulunamadı'], 404);
            }
        

        }
}
