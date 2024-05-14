<?php

namespace Laravel\Jetstream\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;

class UpdateProfileInformationForm extends Component
{
    use WithFileUploads;

    /**
     * The component's state.
     *
     * @var array
     */
    public $state = [];

    /**
    * customized variable initiations
    */
    protected $listeners=['setDate'];
    public $barangays;
    public $birthdate;

    /**
     * The new avatar for the user.
     *
     * @var mixed
     */
    public $photo;

    /**
     * Zip Code.
     *
     * @var mixed
     */
    public $zipCode='';

    /**
     * datepicker for Birthdate
     *
     * @return date
     * @author Gilbert Retiro
     **/
    public function setDate($data)
    {
        $this->state['birthdate']=$data;
    }


    /**
     * Prepare the component.
     *
     * @return void
     */
    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
        ($this->state['date_hired']=='January 01, 1970' || $this->state['date_hired']==NULL) ? $this->state['date_hired']='' :$this->state['date_hired'];
    }

    /**
     * Update the user's profile information.
     *
     * @param  \Laravel\Fortify\Contracts\UpdatesUserProfileInformation  $updater
     * @return void OR route('profile.show');
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater)
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            return redirect()->route('profile.show');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
    }



    /**
     * Delete user's profile photo.
     *
     * @return void
     */
    public function deleteProfilePhoto()
    {
        Auth::user()->deleteProfilePhoto();

        $this->emit('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $departments    = DB::table('departments')->get();
        $countries      = DB::table('countries')->orderBy('country')->get();
        $nationalities  = DB::table('nationalities')->get();
        $religions      = DB::table('religions')->get();
        $genders        = DB::table('genders')->where('id','!=',3)->get();
        $civilStatuses  = DB::table('civil_statuses')->get();
        $this->provinces    = [];
        $this->cities       = [];
        $this->barangays    = [];

        $this->civilStatuses = $civilStatuses;

        if (Auth::user()->country || Auth::user()->province != NULL || Auth::user()->province != '' || $this->state['country']!='') {
            $provinces = DB::table('provinces')
            ->select('province')
            ->distinct()
            ->where('country_code', $this->state['country'])
            ->groupBy('province')
            ->orderBy('province')
            ->get();
            $this->provinces = $provinces;
        }

        if (Auth::user()->city != NULL || Auth::user()->city != '' || $this->state['province']!='') {
            $cities = DB::table('provinces')
            ->select('municipality')
            ->distinct()
            ->where('country_code', $this->state['country'])
            ->where('province', $this->state['province'])
            ->groupBy('municipality')
            ->orderBy('municipality')
            ->get();
            $this->cities = $cities;
        }
        if (Auth::user()->barangay != NULL || Auth::user()->barangay != '' || $this->state['city']!='') {
        // Auth::user()->city);
            $barangays = DB::table('provinces')
            ->select('barangay','id', 'zip_code')
            ->distinct()
            ->where('country_code', $this->state['country'])
            ->where('province', $this->state['province'])
            ->where('municipality', $this->state['city'])
            ->orderBy('barangay')
            ->get();
            $this->barangays = $barangays;
        }

        return view('profile.update-profile-information-form', 
            [
                'departments'   => $departments, 
                'countries'     => $countries,
                'nationalities' => $nationalities,
                /*'provinces'     => $provinces,
                'cities'        => $cities,
                'barangays'     => $barangays,*/
                'religions'     => $religions,
                'genders'       => $genders
            ]
        );
    }

    /**
     * Search for Provinces that can be used for dropdowns 
     * and other functionalities
     *
     * @return Provinces (Array)
     * @param $country
     * @author Gilbert Retiro
     *
     * 
     **/
    public function qProvince ($country)
    {
        // $this->state['province'] ='';
        $select = DB::table('provinces')
                    ->select('province')
                    ->distinct()
                    ->where('country_code', $country)
                    ->get();
        $this->provinces = $select;
    }


    /**
     * Search for Municipalites that can be used for dropdowns 
     * and other functionalities
     *
     * @return birthdate
     * @param $value 
     * @author Gilbert Retiro
     * 
     **/
    public function changeBirthdate ($value) {
        // dd($value);
        $this->birthdate = $value;
    }

    /**
     * Search for Municipalites that can be used for dropdowns 
     * and other functionalities
     *
     * @return Municipalities (Array)
     * @return Cities
     * @param $country 
     * @param $province
     * @author Gilbert Retiro mm/dd/yyyy
     * @author 
     * 
     **/
    public function qMunicipalities ($country, $province)
    {
        $select = DB::table('provinces')
                    ->select('municipality')
                    ->distinct()
                    ->where('country_code', $country)
                    ->where('province', $province)
                    ->get();

        $this->cities = $select;
    }

    /**
     * Search for Barangays that can be used for dropdowns 
     * and other functionalities
     *
     * @return Barangays (Array)
     * @param $country
     * @param $province
     * @param $municipality
     * @author Gilbert Retiro
     *
     * 
     **/
    public function qBarangays ($country, $province, $municipality)
    {
        $select = DB::table('provinces')
                    ->select('barangay', 'zip_code')
                    ->distinct()
                    ->where('country_code', $country)
                    ->where('province', $province)
                    ->where('municipality', $municipality)
                    ->get();
        $this->barangays = $select;
    }

    /**
     * Display Zip Code after slecting barangay
     *
     * @return zip_code
     * @param $country
     * @param $province
     * @param $municipality
     * @author Gilbert Retiro
     *
     * 
     **/
    public function qZipCode ($country, $province, $municipality, $barangay)
    {
        // $this->state['zip_code'] = "1105";

        $select = DB::table('provinces')
                    ->select('zip_code')
                    ->where('country_code', $country)
                    ->where('province', $province)
                    ->where('municipality', $municipality)
                    ->where('barangay', $barangay)->first();
        $this->state['zip_code'] = $select->zip_code;
    }


    public function provinces ($value) {
        $this->state['province'] =''; //This will empty state.province - Gilbert 12/09/2022
        $this->qProvince($value);
        $this->provinces = [];
        $this->cities    = [];
        $this->barangays = [];
        $this->state['zip_code'] = '';
    }

    public function cities ($value) {
        $this->state['city'] =''; //This will empty state.city - Gilbert 12/09/2022
        $this->qProvince($this->state['country']);
        $this->qMunicipalities($this->state['country'], $value);
        $this->barangays = [];
        $this->state['zip_code'] = '';
    }

    public function barangays($value){
        $this->state['barangay'] =''; //This will empty state.barangay - Gilbert 12/09/2022
        $this->qProvince($this->state['country']);
        $this->qMunicipalities($this->state['country'], $this->state['province']);
        $this->qBarangays($this->state['country'], $this->state['province'], $value);
        $this->state['zip_code'] = '';
    }

    public function zipCode($value) {
        $this->qProvince($this->state['country']);
        $this->qMunicipalities($this->state['country'], $this->state['province']);
        $this->qBarangays($this->state['country'], $this->state['province'], $this->state['city']);
        $this->qZipCode($this->state['country'], $this->state['province'], $this->state['city'], $value);
    }

    /*public function webCamModal() {
        // dd('Gibs');
        echo "<script> alert('Gibs'); </script>";
    }*/
}
