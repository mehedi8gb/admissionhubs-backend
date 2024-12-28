<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model as MainModel;
use Illuminate\Support\Carbon;

/**
 * Class Model
 *
 * @property int $id
 * @property string $academic_year
 * @property bool|null $status
 * @property string|null $createdBy
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static \Database\Factories\AcademicYearFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereAcademicYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model inRandomOrder()
 *
 * Additional Methods:
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model orderBy($column, $direction = 'asc')
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model limit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model pluck($column, $key = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model get()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model first()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model findOrFail($id)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model find($id)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model exists()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Model latest()
 *
 * Relationships:
 * @method \Illuminate\Database\Eloquent\Relations\BelongsToMany students()
 * @method \Illuminate\Database\Eloquent\Relations\HasMany courses()
 */

class Model extends MainModel
{

}
