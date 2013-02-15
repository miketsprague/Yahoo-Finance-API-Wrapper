USE finance;

CREATE TABLE Account
(
    id             INTEGER,
    name           CHAR(50)    NOT NULL,
    balance        FLOAT,

    PRIMARY KEY(id)
);

CREATE TABLE AccountOwnedStocks
(
    account_id     INTEGER,
    symbol	   CHAR(10)    NOT NULL,
    type           CHAR(10)    NOT NULL,
    num_shares     FLOAT,
    purchase_price FLOAT,

    PRIMARY KEY(account_id, symbol),
    FOREIGN KEY (account_id) REFERENCES Account(id)
);

