import { Route, Routes } from "react-router-dom";
import Home from "./pages/Home";
import { Navbar } from "./components/Navbar";
import About from "./pages/About";
import Clubs from "./pages/Clubs";
import Store from "./pages/Store";
import Contact from "./pages/Contact";
import Footer from "./components/Footer";
import SignIn from "./pages/SignIn";
import SignUp from "./pages/Signup";
import Club from "./pages/Club";
import NearestGyms from "./pages/NearestGyms";
import axios from "axios";
import SubscriptionForm from "./pages/SubscriptionForm";
import Verification from './pages/Verification'; 



axios.defaults.baseURL="http://localhost:8000/api";


function App() {
  return (
    <>
     <Navbar/>
    <Routes>
     
      <Route path="/" element={<Home/>} />
      <Route path="/clubs" element={<Clubs/>} />
      <Route path="/Store" element={<Store/>} />
      <Route path="/verification" element={<Verification/>} />
      <Route path="/contact" element={<Contact/>} />
      <Route path="/about" element={<About/>} />
      <Route path="/signin" element={<SignIn/>} />
      <Route path="/signup" element={<SignUp/>} />
      <Route path="/clubs/:id" element={<Club/>} />
      <Route path="/nearest" element={<NearestGyms/>} />
      <Route path="pages/subscription" element={<SubscriptionForm/>} />
      
    </Routes>
   
    
    <Footer/>
    </>
  );
  
}

export default App;
