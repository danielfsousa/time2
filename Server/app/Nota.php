<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Nota
 *
 * @property integer $id
 * @property string $prova
 * @property string $data
 * @property integer $nota
 * @property integer $aluno_id
 * @property integer $disciplina_id
 * @property integer $turma_id
 * @property integer $estado_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Estado $estado
 * @property-read \App\Usuario $aluno
 * @property-read \App\Disciplina $disciplina
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereProva($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereNota($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereAlunoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereDisciplinaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereTurmaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereEstadoId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Nota whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read \App\Turma $turma
 * @method static \Illuminate\Database\Query\Builder|\App\Nota withAll()
 */
class Nota extends Model
{
    protected $fillable = [
        'data', 'prova', 'folha_resposta', 'respostas', 'turma_id', 'estado_id', 'aluno_id', 'disciplina_id'
    ];

    const VALIDACAO = [
        'aluno_id' => 'required|integer',
        'prova' => 'required',
        'nota' => 'required|number',
        'folha_repsosta' => 'required',
        'respostas' => 'required',
        'turma_id' => 'required|integer|min:1',
        'estado_id' => 'required|integer|min:1',
        'disciplina_id' => 'required|integer|min:1'
    ];

    const VALIDACAO_UPDATE = [
        'aluno_id' => 'integer',
        'nota' => 'number',
        'turma_id' => 'integer|min:1',
        'estado_id' => 'integer|min:1',
        'disciplina_id' => 'integer|min:1'
    ];

    public static function comQuantidade($notas)
    {
        $quantidade = [
            'todos'      => Nota::count(),
            'aguardando' => Nota::where('estado_id', Estado::AGUARDANDO_CORRECAO)->count(),
            'corrigido'  => Nota::where('estado_id', Estado::CORRIGIDO)->count(),
        ];

        return compact('quantidade', 'notas');
    }

    public function scopeWithAll($query)
    {
        $query->with('turma', 'aluno', 'estado', 'disciplina');
    }

    public function estado()
    {
        return $this->belongsTo('App\Estado');
    }

    public function aluno()
    {
        return $this->belongsTo('App\Usuario', 'aluno_id');
    }

    public function disciplina()
    {
        return $this->belongsTo('App\Disciplina');
    }

    public function turma()
    {
        return $this->belongsTo('App\Turma');
    }
}
