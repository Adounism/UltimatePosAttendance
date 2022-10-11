<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Employe;
use App\User;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasApiTokens;
    use Notifiable;

    protected $guarded = ['id'];
 
    public function employe(){
        return $this->belongsTo(Employe::class);
    }

    protected $fillable = [
        'heure_arriver',
        'heure_deppart',
    ];

            /**
     * Gives locations permitted for the logged in user
     *
     * @param: int $business_id
     * @return string or array
     */
    public function permitted_locations($business_id = null)
    {
        $user = $this;

        if ($user->can('access_all_locations')) {
            return 'all';
        } else {
            $business_id = !is_null($business_id) ? $business_id : request()->session()->get('user.business_id');
            $permitted_locations = [];
            $all_locations = BusinessLocation::where('business_id', $business_id)->get();
            foreach ($all_locations as $location) {
                if ($user->can('location.' . $location->id)) {
                    $permitted_locations[] = $location->id;
                }
            }
            return $permitted_locations;
        }
    }

            /**
     * Returns if a user can access the input location
     *
     * @param: int $location_id
     * @return boolean
     */
    public static function can_access_this_location($location_id, $business_id = null)
    {
        $permitted_locations = auth()->user()->permitted_locations($business_id);
        
        if ($permitted_locations == 'all' || in_array($location_id, $permitted_locations)) {
            return true;
            dd(true);
        }

        return false;
    }
}
