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

db.connect((err) => {
    if (err) {
        console.error("Error connecting to MySQL :", err);
        return;
    }
    console.log('connected to mysql database');
});


app.post('/customer', (req, res) => {
    const {customer_id, name, email, phone_num, password, usename} = req.body
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
        if(err) {
            console.error('Error inserting customer acc:', err);
            res.status(500).json({error: 'an error occurred while inserting customer'});
        } else {
            res.status(200).json({message: 'customer inserted succesfully'});
        }
    })
})

app.get("/", (req, res)=>{
    res.json("Do you only love me 'cause you have to")
})

app.listen(8800, () => {
    console.log("connected to backend")
})