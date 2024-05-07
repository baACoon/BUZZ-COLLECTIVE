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

app.post('/customer', (req, res) => {
    const sql = "INSERT INTO customer(`customer_id`, `name`, `email`, `phone_num`, `password`, `username`) Values (?)";
    const values = [
        req.body.customer_id,
        req.body.name,
        req.body.email,
        req.body.phone_num,
        req.body.password,
        req.body.username,
    ]
    db.query(sql, [values], (err, data) => {
        if(err) return res.json(err);
        return res.json(data);
    })
})

app.get("/", (req, res)=>{
    res.json("Do you only love me 'cause you have to")
})

app.listen(8800, () => {
    console.log("connected to backend")
})