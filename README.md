<h1>Kurulum</h1><br>
git clone https://github.com/atalhatabak/ReservationAppApi.git<br>
cd ReservationAppApi<br>
composer install<br>
php artisan migrate<br>
php artisan db:seed<br>
php artisan serve<br>
<code>.env dosyasını istediğiniz veritabanına uygun şekilde yapılandırınız, sqlite için php.ini üzerinden sqlite eklentisini aktifleştirmeniz gerekiyor. </code><br>

<h1>Kullanımı</h1>
path: /register
method: post
parametreler:
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
path: /login
method: post
parametreler;
<pre>
                'email' => 'required|email',
                'password' => 'required'    
</pre>
Authorization: Bearer <token>
<code>Bundan sonraki her istek için token gönderimi zorunludur</code>




