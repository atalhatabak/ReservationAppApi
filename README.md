<h1>Nedir</h1><br>
Laravel ile yapılmış kayıt, giriş, profil rezervasyon oluşturma, silme, geçmiş rezervasyonları görüntüleme gibi işlevleri olan Api<br>
bu apiyi kullanan mobil uygulama için <a href="https://github.com/atalhatabak/ReservationAppMobile">ReservationAppMobile</a><br>

<h3>Kullanım Videosu</h3>
<a href="https://www.youtube.com/watch?v=keHCc-PwydE"><img src="https://i.ytimg.com/vi/keHCc-PwydE/maxresdefault.jpg" width="50%"></a><br>

<h1>Kurulum</h1><br>
git clone https://github.com/atalhatabak/ReservationAppApi.git<br>
cd ReservationAppApi<br>
composer install<br>
php artisan migrate<br>
php artisan db:seed<br>
php artisan serve<br>
<code>.env dosyasını istediğiniz veritabanına uygun şekilde yapılandırınız, sqlite için php.ini üzerinden sqlite eklentisini aktifleştirmeniz gerekiyor. </code><br>


<h1>Kullanımı</h1>
path: /register <br>
method: post <br>
parametreler: <br>
<pre>
                'name' => 'required',
                'TC' => 'required',
                'phone' => 'required',
                'role' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required'
</pre>
return:
<pre>
                'status' => true,
                'message' => 'User Created Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken,
                'name' => $request->name,
                'role' => $request->role,
</pre>
<hr>

path: /login<br>
method: post<br>
parametreler;<br>
<pre>
                'email' => 'required|email',
                'password' => 'required'    
</pre>
Authorization: Bearer token<br>
<code>Bundan sonraki her istek için token gönderimi zorunludur. JS ile örnek kod</code>
<code>
                axios.get(`${appData.apiUrl}/api/getBranchs`, {
                    headers: {
                      <b>'Authorization': `Bearer ${appData.token}`</b>,
                    }
                  })
</code>
<hr>

path: /getBranchs<br>
method: get<br>
Authorization: Bearer token<br>
<hr>

path: /getAvaibleDates<br>
method: get<br>
parametreler;<br>
<pre>
                branch_id
</pre>
Authorization: Bearer token<br>
<hr>

path: /getCars<br>
method: get<br>
Authorization: Bearer token<br>
<hr>

path: /getReservations<br>
method: get<br>
Authorization: Bearer token<br>
<hr>

path: /addCar<br>
method: post<br>
Authorization: Bearer token<br>
parametreler: <br><br>
<pre>
                'brand' => 'required',
                'model' => 'required',
                'plaka' => 'required',
                'owner' => 'required',
</pre>
<hr>

path: /addReservation<br>
method: post<br>
Authorization: Bearer token<br>
parametreler: <br><br>
<pre>
                'date' => 'required',
                'session' => 'required',
                'branch_id' => 'required',
                'car_id' => 'required',
</pre>
<hr>

path: /deleteReservation<br>
method: delete<br>
Authorization: Bearer token<br>
parametreler: <br><br>
<pre>
                'id' => 'required',
</pre>
<hr>

path: /getPersonalInfo<br>
method: get<br>
Authorization: Bearer token<br>
<hr>

path: /updatePersonalInfo<br>
method: put<br>
Authorization: Bearer token<br>
parametreler: <br><br>
<pre>
                'name' => 'required',
                'TC' => 'required',
                'phone' => 'required',
                'email' => 'required',
</pre>
<hr>






