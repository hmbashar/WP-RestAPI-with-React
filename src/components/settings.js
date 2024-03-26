import React from "react";


function Settings() {
    return (
        <React.Fragment>
            <h2>React Settings Form</h2>
            <form id="work-settings-form">
                <table className="form-table" role="presentation">
                    <tbody>
                        <tr>
                            <th scope="row">
                                <label htmlFor="firstname">First Name</label>
                            </th>
                            <td>
                                <input id="firstname" name="firstname" value="" className="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label htmlFor="lastname">Last Name</label>
                            </th>
                            <td>
                                <input id="lastname" name="lastname" value="" className="regular-text" />
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                <label htmlFor="email">Email</label>
                            </th>
                            <td>
                                <input id="email" name="email" value="" className="regular-text" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <p className="submit">
                    <button type="submit" className="button button-primary">Submit</button>
                </p>
            </form>

        </React.Fragment>
    )
}

export default Settings;