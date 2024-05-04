import express from "express"
import mysql from "mysql"



const app = express()

const db =  mysql.createConnection ({
    host: "localhost",
    user: "root",
    password: "root",
    database: "barbershop"
})

app.listen(8800, () => {
    console.log("connected to backend")
})