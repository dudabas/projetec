USE uaiMenu;

INSERT IGNORE INTO cardapio_dia (dia) VALUES
('segunda-feira'),
('terça-feira'),
('quarta-feira'),
('quinta-feira'),
('sexta-feira'),
('sábado');

ALTER TABLE carne DROP PRIMARY KEY;
ALTER TABLE carne ADD PRIMARY KEY (dia);
ALTER TABLE acompanhamento DROP PRIMARY KEY;
ALTER TABLE acompanhamento ADD PRIMARY KEY (dia);
ALTER TABLE salada DROP PRIMARY KEY;
ALTER TABLE salada ADD PRIMARY KEY (dia);

INSERT IGNORE INTO carne (carne, dia) VALUES
('Bife acebolado', 'segunda-feira'),
('Frango grelhado', 'terça-feira'),
('Carne de panela', 'quarta-feira'),
('Bife à milanesa', 'quinta-feira'),
('Peixe empanado', 'sexta-feira'),
('Carne assada com molho', 'sábado');

INSERT IGNORE INTO acompanhamento (acompanhamento, dia) VALUES
('Arroz branco, feijão carioca e farofa', 'segunda-feira'),
('Arroz integral, feijão preto e purê', 'terça-feira'),
('Arroz, feijão e macarrão', 'quarta-feira'),
('Feijão tropeiro e batata frita', 'quinta-feira'),
('Arroz, feijão e legumes cozidos', 'sexta-feira'),
('Arroz, feijão e batata sauté', 'sábado');

INSERT IGNORE INTO salada (salada, dia) VALUES
('Alface e tomate', 'segunda-feira'),
('Cenoura e beterraba ralada', 'terça-feira'),
('Alface americana e pepino', 'quarta-feira'),
('Repolho e tomate cereja', 'quinta-feira'),
('Mix de folhas com molho', 'sexta-feira'),
('Rúcula e cenoura', 'sábado');

ALTER TABLE cardapio_dia ADD COLUMN imagem VARCHAR(255) NULL;
