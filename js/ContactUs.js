
import React, { useState } from "react";
import './styles/Contactus.css'
import { BsMailbox, BsTelephoneFill } from "react-icons/bs";
import { MdEmail, MdLocationOn } from "react-icons/md";
import img from "../assets/banner.png"
import axios from "axios"

function ContactUs() {

    const [formData, setFormData] = useState({
        name: '',
        email: '',
        subject: '',
        message: '',
    });

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: value,
        });
    };


    const handleSubmit = (e) => {
        e.preventDefault();
        // You can perform form submission logic here
        console.log(formData);
        // Reset form fields after submission if needed
        setFormData({
            name: '',
            email: '',
            subject: '',
            message: '',
        });

        axios.post('/mail', formData)
            .then(response => {
                console.log('Post request successful:', response.FormData);
                // Handle the response data or success message here
            })
            .catch(error => {
                console.error('Error making post request:', error);
                console.error('Error response from server:', error.response);
    });
    }
    return (
        <div className='Contactus'>
            <div className='ContactForm'>
                <div className='Getintouch'>
                    <p className='bv'>BIENVENUE SUR Flexzone</p>
                    <p className='getin'>Prenez contact avec nous</p>
                    <p className='text-horaires'>If you have any feedback or questions about our clubs, our website or our services in general, please contact us by filling out the form. </p>
                    <div className='oh'>heures d'ouverture</div>
                    <div className='horaires'>
                        <p className='text-horaires'><a>Lun - Ven :</a> 08.00 AM to 09.00 PM</p>
                        <p className='text-horaires'><a>Sat :</a> 09.00 AM to 06.00 PM</p>
                        <p className='text-horaires'><a>Sunday :</a> 09.00 AM to 02.00 PM</p>
                    </div>
                </div>
                <div className='Form'>
                    <p className='getin'>Envoie-nous un message</p>
                    <p className='bv'>Votre adresse email ne sera pas publiée *</p>
                    <form onSubmit={handleSubmit}>
                        <input
                            name='name'
                            placeholder='name complete'
                            value={formData.name}
                            onChange={handleInputChange}
                        />
                        <input
                            name='email'
                            placeholder='adresse email'
                            value={formData.email}
                            onChange={handleInputChange}
                        />
                        <input
                            name='subject'
                            placeholder='subjet'
                            value={formData.subject}
                            onChange={handleInputChange}
                        />
                        <input
                            name='message'
                            placeholder='message'
                            value={formData.message}
                            onChange={handleInputChange}
                        />
                        <button type='submit' >
                            Envoyer maintenant
                        </button>
                    </form>
                </div>

            </div>
            <div className='ContactInfos' style={{ backgroundImage: `url(${img})` }}>
                <div className='InfosContainer'>
                    <div className='info1'>
                        <a><BsTelephoneFill /></a>
                        <p>Phone</p>
                        <hr className='Devider' />
                        (+212) 123456789
                    </div>
                    <div class="verticalLine"></div>

                    <div className='info1'>
                        <a><MdEmail /></a>
                        <p> Mail</p>
                        <hr className='Devider' />
                        contact@flexzone.com
                    </div>
                    <div class="verticalLine"></div>

                    <div class="verticalLine"></div>
                    <div className='info1'>
                        <a><MdLocationOn /></a>
                        <p>Localisation</p>
                        <hr className='Devider' />
                        Martil . Maroc
                    </div>
                </div>
            </div>

        </div>
    )
}

export default ContactUs