<h1>Kurulum</h1>
<p>
git clone https://github.com/atalhatabak/ReservationAppApi.git
cd ReservationAppApi
composer install
php artisan migrate
php artisan db:seed
<code>.env dosyasını istediğiniz veritabanına uygun şekilde yapılandırınız, sqlite için php.ini üzerinden sqlite eklentisini aktifleştirmeniz gerekiyor. </code>
</p>
