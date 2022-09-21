import React from 'react';
import AdminAuthenticatedLayout from '@/Layouts/Admin/AdminAuthenticatedLayout';
import ListView from '@/Shared/ListView';
import User from '@/Shared/User';

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
        view : 'name:Role,users:Username',
        route : 'permission.show'
    }

    return (
       <AdminAuthenticatedLayout>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                        <ListView
                            listprops={listprops}
                        ></ListView>
                        
                    </div>
                </div>
            </div>
        </AdminAuthenticatedLayout>
    );
}


