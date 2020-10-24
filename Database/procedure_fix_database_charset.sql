ALTER TABLE explicacoespaginas MODIFY COLUMN slug VARCHAR(100);
ALTER TABLE ged_rules MODIFY COLUMN slug VARCHAR(100);
ALTER TABLE ged_rules MODIFY COLUMN type VARCHAR(100);
ALTER TABLE modulos MODIFY COLUMN identificador VARCHAR(100);
ALTER TABLE permissoes MODIFY COLUMN identificador VARCHAR(100);

DROP PROCEDURE change_charset_and_collation;
CREATE PROCEDURE change_charset_and_collation()
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE schemaToUpdate VARCHAR(20);
    DECLARE tableToUpdate VARCHAR(255);
    DECLARE cursorTable CURSOR FOR SELECT TABLE_NAME
                                   FROM information_schema.TABLES
                                   WHERE TABLE_SCHEMA = 'sigep' AND TABLE_COLLATION <> 'utf8mb4_unicode_ci';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    SET schemaToUpdate = 'sigep';

    OPEN cursorTable;

    ALTER DATABASE sigep
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

    REPEAT
      FETCH cursorTable
      INTO tableToUpdate;
      IF (NOT done AND tableToUpdate <> 'migrations_log')
      THEN
        CALL generateColumnsUpdateQuery(tableToUpdate);
        SELECT @tableToUpdate := CONCAT('ALTER TABLE sigep_test.', tableToUpdate,
                                        ' CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;');

        PREPARE tableQuery FROM @tableToUpdate;
        EXECUTE tableQuery;
        DEALLOCATE PREPARE tableQuery;
      END IF;
    UNTIL done END REPEAT;

    CLOSE cursorTable;
  END;

# DROP PROCEDURE generateColumnsUpdateQuery;
CREATE PROCEDURE generateColumnsUpdateQuery(tableToUpdate VARCHAR(200))
  BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE columnToUpdate VARCHAR(200);
    DECLARE cursorTable CURSOR FOR SELECT COLUMN_NAME
                                   FROM information_schema.COLUMNS
                                   WHERE table_schema = 'sigep_test' AND TABLE_NAME = tableToUpdate AND
                                         COLLATION_NAME <> 'utf8mb4_unicode_ci' AND
                                         COLLATION_NAME IS NOT NULL;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cursorTable;

    REPEAT
      FETCH cursorTable
      INTO columnToUpdate;
      IF (NOT done AND tableToUpdate <> 'migrations_log')
      THEN
        IF instr(tableToUpdate, 'versioning') > 0 THEN
          SELECT @columnToUpdate :=
               concat('UPDATE sigep_test.', tableToUpdate, ' AS table1 SET `', columnToUpdate,
                      '` = (SELECT CONVERT(CONVERT(CONVERT(`',
                      columnToUpdate, '` USING latin1) USING binary) USING UTF8) FROM (SELECT * FROM sigep_test.', tableToUpdate,
                      ') AS table2 WHERE table1._id = table2._id);');
        ELSE
          SELECT @columnToUpdate :=
                 concat('UPDATE sigep_test.', tableToUpdate, ' AS table1 SET `', columnToUpdate,
                        '` = (SELECT CONVERT(CONVERT(CONVERT(`',
                        columnToUpdate, '` USING latin1) USING binary) USING UTF8) FROM (SELECT * FROM sigep_test.', tableToUpdate,
                        ') AS table2 WHERE table1.id = table2.id);');
        END IF;

        PREPARE myquery FROM @columnToUpdate;
        EXECUTE myquery;
        DEALLOCATE PREPARE myquery;
      END IF;
    UNTIL done END REPEAT;

    CLOSE cursorTable;
  END;

CALL change_charset_and_collation();

SELECT * FROM gedavaliacoes;

DELETE FROM gedavaliacoes;

SELECT * FROM gedresultadosconhecimentos;
SELECT * FROM gedresultadoscompetencias;
SELECT * FROM gedresultadosdesempenhos;

DELETE FROM gedresultadosconhecimentos;
DELETE FROM gedresultadoscompetencias;
DELETE FROM gedresultadosdesempenhos;
UPDATE gedresultados SET comentario_geral = NULL WHERE comentario_geral IS NOT NULL;

UPDATE gedresultados SET finalizado = 1 WHERE finalizado = 2;


DELETE FROM gedresultados;

SELECT * FROM gedresultados WHERE comentario_geral IS NOT NULL;
SELECT * FROM gedresultados ;
SELECT * FROM gedmetasexerciciosfuncionarios;
UPDATE gedresultados SET comentario_geral = NULL WHERE comentario_geral IS NOT NULL;

SELECT * FROM empresas;
DELETE FROM empresas;   