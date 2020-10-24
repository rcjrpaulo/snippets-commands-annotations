<?php

//exemplo de callback de relacionamento
$xxx = (new DepartmentPosition)->with(
            [
                'position' => function ($query) use ($companyId) {
                    $query->where('empresa_id', $companyId);
                },
                'department' => function ($query) use ($companyId) {
                    $query->where('empresa_id', $companyId);
                }
            ]
        )->get();

//exemplo de updateOrCreate
$where = ['id' => null];

        $data = [
            'empresa_id' => $this->empresa_id,
            'descricao' => 'Uma descricao',
            'nome' => 'Um nome'
        ];
        $xxx = (new LeadershipPerception)->updateOrCreate($where, $data);

/*
*
*
*MAPTOGROUPS
*
*/
$collection = collect([
    [
        'name' => 'John Doe',
        'department' => 'Sales',
    ],
    [
        'name' => 'Jane Doe',
        'department' => 'Sales',
    ],
    [
        'name' => 'Johnny Doe',
        'department' => 'Marketing',
    ]
]);

$grouped = $collection->mapToGroups(function ($item, $key) {
    return [$item['department'] => $item['name']];
});

$grouped->toArray();

/*
    [
        'Sales' => ['John Doe', 'Jane Doe'],
        'Marketing' => ['Johnny Doe'],
    ]
*/

$grouped->get('Sales')->all();

// ['John Doe', 'Jane Doe']

/*
 *FIM DO MAPTOGROUPS
 *
 */


//usar orWhere com multiplos Where's
$q->where(function ($query) {
    $query->where('gender', 'Male')
        ->where('age', '>=', 18);
})->orWhere(function($query) {
    $query->where('gender', 'Female')
        ->where('age', '>=', 65); 
})

//rodar sql puro
$SQL_query = "select c.id id, c.nome nome from corretores as c where c.ativo = 'a' order by c.nome asc";
return DB::select($SQL_query);

//verificar se foi create do firstOrCreate
$entity->wasRecentlyCreated

//o where comparando datas diferentes só funciona desse jeito pq a data é tratada como string!
->whereRaw('data_alteracao_pendente != prazo')

// https://laravel-news.com/eloquent-tips-tricks