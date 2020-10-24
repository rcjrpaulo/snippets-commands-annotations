<?php

if ($this->request->isPost() && $isXlsFile) {
    $empresa_id = $this->empresa_id;

    $xlsFile = $data['tmp_name'];
    $stringMessed = file_get_contents($xlsFile);
    $stringFixed = iconv('Windows-1252', 'UTF-8', $stringMessed);
    file_put_contents($xlsFile, $stringFixed);

    $file = \PhpOffice\PhpSpreadsheet\IOFactory::load($xlsFile);
    $data = $file->getActiveSheet()->toArray();

    $userData = [];
    foreach ($data as $key => $value) {
        if ($key != 0) {
            $nome = $value[0];
            $email = $value[1];
            $cargo = $value[2];
            $area = $value[3];
            $gestorNome = $value[4];

            $gestorId = null;
            if ($gestorNome) {
                $gestorId = (New User)->getManagerIdByName($gestorNome, $empresa_id);
            }

            if (strpos($area, '»') !== false) {
                $area = explode(' ', $area);
            }
            $cargoId = (new Position)->getPositionIdByName($cargo, $area, $empresa_id);
            $areaId = (new Department)->getDepartmentIdB yNames($area, $cargo, $empresa_id);

            $senha = $this->gerarSenha(6);
            $senha = $this->Auth->password($senha);
            $userData[$key] = [
                'nome' => $nome,
                'email_prof' => $email,
                'usuario' => $this->gerarUsuario(),
                'senha' => $senha
            ];
            $user[$key] = (new User)->create($userData[$key]);

            $employeeData[$key] = [
                'empresa_id' => $empresa_id,
                'usuario_id' => $user[$key]->id,
                'gestor_id' => $gestorId,
                'empresascargo_id' => $cargoId,
                'empresasarea_id' => $areaId
            ];

            $employee[$key] = (new Employee)->create($employeeData[$key]);
        }
    }
}