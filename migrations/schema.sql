CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    chat_id BIGINT UNIQUE NOT NULL,
    username TEXT,
    first_name TEXT,
    package TEXT DEFAULT 'free',
    expiry BIGINT DEFAULT 0,
    date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS payments (
    id SERIAL PRIMARY KEY,
    reference TEXT UNIQUE NOT NULL,
    chat_id BIGINT,
    amount INTEGER,
    package TEXT,
    status TEXT,
    paid_at TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
