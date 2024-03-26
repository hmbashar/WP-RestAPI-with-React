import React, { useState, useEffect } from "react";
import axios from "axios";

const Settings = () => {

    const [firstname, setFirstname] = useState("");
    const [lastname, setLastname] = useState("");
    const [email, setEmail] = useState("");
    
    const [loader, setLoader] = useState("Save Settings");

    const url = `${appLocalizer.apiURL}/wprest/v1/settings`;

    const handelSubmit = (e) => {
        e.preventDefault();
        setLoader("Saving...");
        axios.post(url, {
           firstname: firstname,
           lastname: lastname,
           email: email 
        },
        {
            headers: {
                'X-WP-Nonce': appLocalizer.nonce
            }
        }).then((res) => {
            setLoader("Save Settings");
            alert("Settings saved successfully");
        }).catch((err) => {
            setLoader("Save Settings");
            alert("Something went wrong");
        }
        );
    }

    useEffect(() => {
        axios.get(url).then((res) => {
          setFirstname(res.data.firstname);
          setLastname(res.data.lastname);
          setEmail(res.data.email);  
        });
    }, []);

    return (
        <React.Fragment>
            <h2>React Settings Form</h2>
            <form id="work-settings-form" className="settings-form" onSubmit={(e) => handelSubmit(e)}>
                <table className="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label htmlFor="firstname">First Name</label>
                            </th>
                            <td>
                                <input id="firstname" name="firstname" value={firstname} className="regular-text" onChange={(e) => setFirstname(e.target.value)}/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label htmlFor="lastname">Last Name</label>
                            </th>
                            <td>
                                <input id="lastname" name="lastname" value={lastname} className="regular-text" onChange={(e) => setLastname(e.target.value)}/>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label htmlFor="email">Email</label>
                            </th>
                            <td>
                                <input id="email" name="email" value={email} className="regular-text" onChange={(e) => setEmail(e.target.value)}/>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p className="submit">
                    <button type="submit" className="button button-primary">{loader}</button>
                </p>
            </form>

        </React.Fragment>
    )
}

export default Settings;