import { BrowserRouter, Routes, Route, } from 'react-router-dom';
import './App.css';
import Signup from './createacc/Signup';
import Home from './home';


function App() {
  return (
    <div className="App">
      <BrowserRouter>
      <Routes>
      <Route path='/Home' element ={<Home/>} />
      <Route path='/SignUp' element ={<Signup/>} />

      </Routes>
      
      </BrowserRouter>
  
       
    </div>
  );
}

export default App;
