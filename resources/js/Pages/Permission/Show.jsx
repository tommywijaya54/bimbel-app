import React from 'react';
import ListView from '@/Shared/ListView';
import User from '@/Shared/User';
import Users from '@/Shared/Users';
import MainLayout from '@/Layouts/MainLayout';

const Permission = ({permission}) => {
    return <div className='permission'>
        {permission.name}
    </div>
}

const Permissions = ({r_permissions, permissions}) => {
    if (r_permissions.length == 0){
        return <div className='inline-info'>no permission assign to this role</div>;
    }

    let easyPermissions = {}; 
    permissions.forEach((permission) => {
        easyPermissions[permission.id] = permission;
    })

    return (<div className='permission-list list permissions'>
        <h4 className='font-bold text-xl'>Permission List</h4>
        {
            r_permissions.map((pr, pr_id) => {
                const apr = easyPermissions[pr.permission_id];
                return <Permission permission={apr} key={pr_id}></Permission>
            })
        }
    </div>);
}

export default function Show(props) {
    return (
       <MainLayout>
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className='p-8 flex flex-wrap'>
                            <h1 className='mb-8 font-bold text-2xl w-full'>Role : {props.role.name}</h1>
                            <Permissions r_permissions={props.role_permissions} permissions={props.permissions}></Permissions>
                            <Users users={props.users}></Users>
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}


