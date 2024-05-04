import express from "express"
import mysql from "mysql"
import cors from "cors"



const app = express()

app.use(cors());
app.use(express.json());


const db =  mysql.createConnection ({
    host: "localhost",
    user: "root",
    password: "root",
    database: "barbershop"
})

app.post('/Signup', (req, res) => {
    const sql = "INSERT INTO signup (`name`, `email`, `password`) Values (?)";
    const values = [
        req.body.name,
        req.body.email,
        req.body.password,
    ]
    db.query(sql, [values], (err, data) => {
        if(err) return res.json(err);
        return res.json(data);
    })
})
app.listen(8800, () => {
    console.log("connected to backend")
})