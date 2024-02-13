import ReactDOM from "react-dom";
import React, {useEffect} from "react";
import {getUser, saveUserData} from "../../store/actions/UserActions";

import {connect} from "react-redux";
import {toast} from 'react-toastify';
import 'react-toastify/dist/ReactToastify.css';



function EditProfile({ userState, getUser, saveUserData,userid}){
    useEffect(()=> {
        getUser(userid)
    },[])

    toast.configure()
    //setFormState(userState);
    const handleSubmit = (e) => {
        e.preventDefault();


        if(e.target.firstname.value)
        {
            userState.users.first_name = e.target.firstname.value
        }
        if(e.target.lastname.value){
            userState.users.last_name = e.target.lastname.value
        }
        if(e.target.email.value){
            userState.users.email = e.target.email.value
        }
        if(e.target.birthday.value){
            userState.users.birthday = e.target.birthday.value
        }
        if(e.target.currentweight.value){
            userState.users.current_weight = e.target.currentweight.value
        }
        if(e.target.hrate.value)
        {
            userState.users.rest_heart_rate = e.target.hrate.value
        }
        if(e.target.phone.value){
            userState.users.phone = e.target.phone.value
        }
        if(e.target.gender.value){
            userState.users.gender = e.target.gender.value
        }

        saveUserData(userState.users,userid);

        toast.success("Profile Successfully Updated")
    }

    return userState.loading?(
        <h2>Loading</h2>
    ): userState.error? (
        <h2>{userState.error}</h2>
    ): (
            <div className="container sizing-profile">


                        <div className="card shadow-sm">
            <form className="form-control" action="" onSubmit={(handleSubmit)}>
                <div className="form-group">
                    <label className="form-input-label">First Name</label>
                    <input
                        type="text"
                        id='firstname'
                        placeholder= {userState.users.first_name}
                    />
                    <label className="form-input-label">Last Name</label>
                    <input
                        type="text"

                        id='lastname'
                        placeholder= {userState.users.last_name}
                    />
                    <label className="form-input-label">Email</label>
                    <input
                        type="email"

                        id='email'
                        placeholder= {userState.users.email}
                    />
                    <label htmlFor='gender-label'className="form-input-label">Gender</label>
                    <select name="gender-label" id="gender">
                        placeholder= {userState.users.gender}
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Non-Binary">Non-Binary</option>

                    </select>
                    <label className="form-input-label">Birthdate</label>
                    <input
                        type="date"

                        id='birthday'
                        placeholder= {userState.users.birthday}
                    />

                    <label className="form-input-label">Weight</label>
                    <input
                        type="number"

                        id='currentweight'
                        placeholder= {userState.users.current_weight}
                    />

                <label className="form-input-label">Phone</label>
                <input
                    type="text"

                    id='phone'
                    placeholder= {userState.users.phone}
                />
                    <label className="form-input-label">Resting Heart Rate</label>
                    <input
                        type="text"
                        id='hrate'
                        placeholder= {userState.users.rest_heart_rate}
                    />
                        </div>

                <button className="btn-primary create-treatment-button" type={"submit"} >Submit</button>
            </form>
        </div>
        </div>

    )
}



const mapStateToProps = state => {
    return {
        userState: state.user
    }
}
const mapDispatchToProps = dispatch =>{
    return {
        getUser: (userid) => dispatch(getUser(userid)),
       saveUserData: (state,userid) => dispatch(saveUserData(state ,userid))

    }
}

if (document.getElementById('editprofileoutput')) {
    ReactDOM.render(<EditProfile userid = {userid}/>, document.getElementById('editprofileoutput'));
}
export default connect(mapStateToProps,mapDispatchToProps)(EditProfile)
