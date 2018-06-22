<?php

namespace TestSeeder;

use Illuminate\Database\Seeder;
use App\Models\Region;

class RegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //-- key => provice
        //-- value => districts
        $regions = [
            'Central' => [
                'Chibombo', 'Kabwe', 'Kapiri Mposhi', 'Mkushi', 'Mumbwa', 'Serenje'
            ],
            'Copperbelt' => ['Chililabombwe', 'Chingola', 'Kalulushi', 'Kitwe', 'Luanshya', 'Lufwanyama', 'Masaiti', 'Mpongwe', 'Mufulira', 'Ndola'],
            'Eastern' => ['Chadiza', 'Chipata', 'Katete', 'Lundazi', 'Mambwe', 'Nyimba', 'Petauke', 'Sinda', 'Vubwi'],
            'Luapula' => ['Chembe', 'Chiengi', 'Chipili', 'Kawambwa', 'Lunga', 'Mansa', 'Milengi', 'Mwansabombwe', 'Mwense', 'Nchelenge', 'Samfya'],
            'Lusaka' => [' Chilanga', 'Chirundu', 'Chongwe', 'Kafue', 'Luangwa', 'Lusaka', 'Rufunsa' , 'Shibuyunji'],
            'Muchinga' => ['Chama', 'Chinsali', 'Isoka', 'Mafinga', 'Mpika', 'Nakonde', 'Shiwang\'andu'],
            'North-Western' => ['Chavuma', 'Ikelenge', 'Kabompo', 'Kasempa', 'Manyinga', 'Mufumbwe', 'Mwinilunga', 'Solwezi', 'Zambezi'],
            'Northern' => ['Chilubi', 'Kaputa', 'Kasama', 'Luwingu', 'Mbala', 'Mporokoso', 'Mpulungu', 'Mungwi', 'Nsama'],
            'Southern' => [' Chikankata', 'Choma', 'Gwembe', 'Kalomo', 'Kazungula', 'Livingstone', 'Mazabuka', 'Monze', 'Namwala', 'Pemba', 'Siavonga', 'Sinazongwe', 'Zimba'],
            'Western' => [' Kalabo', 'Kaoma', 'Lukulu', 'Mongu', 'Mulobezi', 'Senanga', 'Sesheke', 'Shangombo', 'Nalolo', 'Limulunga', 'Nkeyema', 'Sikongo', 'Sioma', 'Mitete', 'Mwandi', 'Luampa']
        ];

        foreach ($regions as $key => $districts) {
            $provice = Region::create([
                'name' => $key,
                'label_name' => 'provice',
                'parent_id' => null
            ]);

            foreach ($districts as $key => $district) {
                Region::create([
                    'name' => $district,
                    'label_name' => 'district',
                    'parent_id' => $provice->id,
                ]);
            }
        }
    }
}
