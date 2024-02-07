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

path: /login
method: post
parametreler;
<pre>
                'email' => 'required|email',
                'password' => 'required'    
</pre>
Authorization: Bearer <token>
<code>Bundan sonraki her istek için token gönderimi zorunludur. JS ile örnek kod</code>
<code>
                axios.get(`${appData.apiUrl}/api/getBranchs`, {
                    headers: {
                      <b>'Authorization': `Bearer ${appData.token}`</b>,
                    }
                  })
</code>
<hr>

path: /getBranchs
method: get
Authorization: Bearer <token>
<hr>

path: /getAvaibleDates
method: get
parametreler;
<pre>
                branch_id
</pre>
Authorization: Bearer <token>
<hr>

path: /getCars
method: get
Authorization: Bearer <token>
<hr>

path: /getReservations
method: get
Authorization: Bearer <token>
<hr>

path: /addCar
method: post
Authorization: Bearer <token>
parametreler: <br>
<pre>
                'brand' => 'required',
                'model' => 'required',
                'plaka' => 'required',
                'owner' => 'required',
</pre>
<hr>

path: /addReservation
method: post
Authorization: Bearer <token>
parametreler: <br>
<pre>
                'date' => 'required',
                'session' => 'required',
                'branch_id' => 'required',
                'car_id' => 'required',
</pre>
<hr>

path: /deleteReservation
method: delete
Authorization: Bearer <token>
parametreler: <br>
<pre>
                'id' => 'required',
</pre>
<hr>

path: /getPersonalInfo
method: get
Authorization: Bearer <token>
parametreler: <br>
<hr>

path: /updatePersonalInfo
method: put
Authorization: Bearer <token>
parametreler: <br>
<pre>
                'name' => 'required',
                'TC' => 'required',
                'phone' => 'required',
                'email' => 'required',
</pre>
<hr>






