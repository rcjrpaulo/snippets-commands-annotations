#CRIANDO PROCEDURE PRA RESETAR BANCO DE TESTES
DELIMITER $$
CREATE PROCEDURE resetsigeptest()
BEGIN
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE sysfeedbacks_comentarios;
TRUNCATE padraocohrosgedgraficos;
TRUNCATE padraocohrosrankings;
TRUNCATE empresas;
TRUNCATE competencias;
TRUNCATE competencias_versioning;
TRUNCATE competenciasgrupos;
TRUNCATE competenciasgrupos_versioning;
TRUNCATE empresascompetenciasgrupos;
TRUNCATE empresascompetencias;
TRUNCATE empresascompetencias_versioning;
TRUNCATE empresascompetenciasgrupos_versioning;
TRUNCATE sugestoestipos;
TRUNCATE psci_bancoquestoes;
TRUNCATE ppiclassificacoes;
TRUNCATE ppibancoquestoes;
TRUNCATE staffpermissoesactions;
TRUNCATE staffpermissoes;
TRUNCATE explicacoespaginas;
TRUNCATE empresasdesempenhos;
TRUNCATE empresasdesempenhos_versioning;
TRUNCATE empresasindicadores;
TRUNCATE empresasindicadores_versioning;
TRUNCATE empresasconhecimentos;
TRUNCATE empresasconhecimentos_versioning;
TRUNCATE empresasareas;
TRUNCATE empresasareas_versioning;
TRUNCATE empresaspercepcoesliderancas;
TRUNCATE empresaspercepcoesliderancas_versioning;
TRUNCATE indicadores_processos;
TRUNCATE empresascargoscompetencias;
TRUNCATE empresascargoscompetencias_versioning;
TRUNCATE empresascargos;
TRUNCATE empresascargos_versioning;
TRUNCATE empresascargospercepcoesliderancas;
TRUNCATE empresascargospercepcoesliderancas_versioning;
TRUNCATE empresascargosconhecimentos;
TRUNCATE empresascargosconhecimentos_versioning;
TRUNCATE empresascargosindicadores;
TRUNCATE empresascargosindicadores_versioning;
TRUNCATE funcionariosdocumentos;
TRUNCATE funcionariosdocumentostipos;
TRUNCATE funcionarios;
TRUNCATE funcionarios_versioning;
TRUNCATE enderecos;
TRUNCATE funcionariospermissoes;
TRUNCATE empresascompetenciasniveis;
TRUNCATE empresascompetenciasniveis_versioning;
TRUNCATE empresasrankings;
TRUNCATE empresasrankings_versioning;
TRUNCATE gedavaliacoes;
TRUNCATE gedavaliacoescompetencias;
TRUNCATE gedavaliacoesconhecimentos;
TRUNCATE gedavaliacoesfuncionariosdesconsiderados;
TRUNCATE gedavaliacoesindicadores;
TRUNCATE gedavaliacoespercepcoesliderancas;
TRUNCATE gedresultados;
TRUNCATE gedavaliacaocontinuaresultados;
TRUNCATE gedavaliacaocontinuaresultadoscompetencias;
TRUNCATE gedavaliacaocontinuaresultadosconhecimentos;
TRUNCATE gedavaliacaocontinuaresultadosdesempenhos;
TRUNCATE gedfeedback;
TRUNCATE gedpdi;
TRUNCATE gedgraficos;
TRUNCATE gedscores;
TRUNCATE gedresultadosdesempenhos;
TRUNCATE gedresultadoscompetencias;
TRUNCATE gedresultadosconhecimentos;
TRUNCATE gedresultadospercepcoesliderancas;
TRUNCATE gedindicadoresfuncionarios;
TRUNCATE gedemails;
TRUNCATE gedindicadoresranges;
TRUNCATE ocorrencias;
TRUNCATE ocorrencias_funcionarios;
TRUNCATE ocorrenciascomentarios;
TRUNCATE pdi_comentarios;
TRUNCATE pdi_comunicados;
TRUNCATE pdi_documentos;
TRUNCATE pdi_empresascompetencias;
TRUNCATE pdi_empresasconhecimentos;
TRUNCATE pdi_empresasdesempenhos;
TRUNCATE pdi_logs;
TRUNCATE pdi_registros;
TRUNCATE gedpdi;
TRUNCATE pdi;
SET FOREIGN_KEY_CHECKS = 1;
DELETE FROM usuarios WHERE id NOT IN (SELECT id FROM (SELECT * from usuarios ) u WHERE u.nome = 'COHROS' OR u.nome LIKE 'Caique Santos');
END
$$
DELIMITER ;

#RESETAR O GED
DELIMITER $$
CREATE PROCEDURE resetged()
BEGIN
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE gedavaliacoes;
TRUNCATE gedavaliacoescompetencias;
TRUNCATE gedavaliacoesconhecimentos;
TRUNCATE gedavaliacoesfuncionariosdesconsiderados;
TRUNCATE gedavaliacoesindicadores;
TRUNCATE gedavaliacoespercepcoesliderancas;
TRUNCATE gedresultados;
TRUNCATE gedavaliacaocontinuaresultados;
TRUNCATE gedavaliacaocontinuaresultadoscompetencias;
TRUNCATE gedavaliacaocontinuaresultadosconhecimentos;
TRUNCATE gedavaliacaocontinuaresultadosdesempenhos;
TRUNCATE gedfeedback;
TRUNCATE gedpdi;
TRUNCATE gedscores;
TRUNCATE gedresultadosdesempenhos;
TRUNCATE gedresultadoscompetencias;
TRUNCATE gedresultadosconhecimentos;
TRUNCATE gedresultadospercepcoesliderancas;
TRUNCATE gedindicadoresfuncionarios;
TRUNCATE ocorrencias;
TRUNCATE ocorrencias_funcionarios;
TRUNCATE ocorrenciascomentarios;
TRUNCATE funcionariospermissoes;
TRUNCATE pdi_comentarios;
TRUNCATE pdi_comunicados;
TRUNCATE pdi_documentos;
TRUNCATE pdi_empresascompetencias;
TRUNCATE pdi_empresasconhecimentos;
TRUNCATE pdi_empresasdesempenhos;
TRUNCATE pdi_logs;
TRUNCATE pdi_registros;
TRUNCATE gedpdi;
TRUNCATE pdi;
SET FOREIGN_KEY_CHECKS = 1;
END
$$
DELIMITER ;