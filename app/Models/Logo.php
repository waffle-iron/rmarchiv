<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Logo
 *
 * @property integer $id
 * @property string $title
 * @property string $extension
 * @property string $filename
 * @property integer $user_id
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereExtension($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereFilename($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Logo whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\LogoVote[] $logovote
 * @property-read integer $voteresult
 */
class Logo extends Model
{
    protected $table = 'logos';

    public $timestamps = true;

    protected $fillable = [
        'title',
        'extension',
        'filename',
        'user_id'
    ];

    protected $guarded = [];

    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function logovote(){
        return $this->belongsToMany('App\Models\LogoVote');
    }

    public function voteresult(){
        $up = LogoVote::whereLogoId($this->id)->selectRaw('SUM(up) as sumup, SUM(down) as sumdown');

        $res = $up->get(array('sumup', 'sumdown'));

        return $res;
    }
        
}