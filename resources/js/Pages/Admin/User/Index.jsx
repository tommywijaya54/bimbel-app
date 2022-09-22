import React from 'react';
import AdminAuthenticatedLayout from '@/Layouts/Admin/AdminAuthenticatedLayout';
import ListView from '@/Shared/ListView';
import User from '@/Shared/User';
import RouteLink from '@/Shared/RouteLink';


const Role = ({role}) => {
    // <RouteLink ob={role} routename="permission.show"></RouteLink>
    return <>
        <div className='role'>
            {role.name}
        </div>
    </>;
}

const Roles = ({roles}) => {
    if(roles.length == 0) return "No Roles"

    return <>
        <div className='user-roles'>
            {roles.map((role,key) => <Role key={key} role={role}></Role> )}
        </div>
    </>
}

export default function Index(props) {

    // Permission : role - permission - users
    let users = props.data;
    users = users.map((user) => {
        user.role = <Roles roles={user.roles}></Roles>
        return user;
    })

    const listprops = {
        data : users,
        view : 'name,email'
        // route : 'user.show'
    }

    return (
       <AdminAuthenticatedLayout>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    
                        
                    </div>
                </div>
            </div>
        </AdminAuthenticatedLayout>
    );
}




