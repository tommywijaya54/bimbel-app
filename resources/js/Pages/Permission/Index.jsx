import React from 'react';
import ListView from '@/Shared/ListView';
import User from '@/Shared/User';
import MainLayout from '@/Layouts/MainLayout';

export default function Index(props) {

    // Permission : role - permission - users
    const users = props.users;
    
    const roles =  props.roles.map((role) => {
        let newrole = {...role};
        newrole.users = [];
        newrole.users = users.filter(function( user ) {
            for (let i = 0; i < user.roles.length; i++) {
                const urole = user.roles[i];
                if(urole.name == role.name){
                    return true;
                }
            }
            return false;
        }).map((user, userKey) => {
            return <User key={userKey} user={user}></User>
        });
        return newrole;
    });

    const listprops = {
        data : roles,
        fields : 'name:Role,users:Users',
        item_url : '/role/{id}'
    }

    return (
       <MainLayout
            auth={props.auth}
            errors={props.errors}
            title="Role and Permission List"
            header_action={props.action_button}
            >
                <div className="overflow-x-auto bg-white rounded shadow">
                    <ListView
                        listprops={listprops}
                    ></ListView>
                </div>
        </MainLayout>
    );
}


