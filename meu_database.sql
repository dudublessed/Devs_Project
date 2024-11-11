CREATE TABLE associates (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    cpf VARCHAR(14) UNIQUE NOT NULL,
    data_filiacao DATE NOT NULL
);

CREATE TABLE annuities (
    id SERIAL PRIMARY KEY,
    ano INTEGER UNIQUE NOT NULL,
    valor NUMERIC(10, 2) NOT NULL
);

CREATE TABLE associate_annuities (
    id SERIAL PRIMARY KEY,
    associate_id INTEGER NOT NULL,
    annuity_id INTEGER NOT NULL,
    pagamento_efetuado BOOLEAN DEFAULT FALSE, 
    FOREIGN KEY (associate_id) REFERENCES associates(id),
    FOREIGN KEY (annuity_id) REFERENCES annuities(id),
    CONSTRAINT unique_associate_annuity UNIQUE (associate_id, annuity_id)
);
