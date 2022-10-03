import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function Show(props) {
    const permissionGroupByCategory = props.role_permission.reduce((group, permission) => {
        const group_name = permission.name.split("-")[1];

        group[group_name] = group[group_name] ?? [];
        group[group_name].push(permission);

        return group;
    }, {});

    console.log(permissionGroupByCategory);


    return (
        <MainLayout
            {...props}
        >
            <Form
                {...props.form_schema}
            >
                <div className="form-component pr-6 pb-8 w-full lg:w-1/2">
                    <label className="form-label">Users:</label>
                    <div className="form-input">
                        {props.users.map(user => <span className="unit">{user.name}</span>)}
                    </div>
                </div>

                <div>
                    <div className="form-component pr-6 pb-8 w-full">
                        <label className="form-label">Role Permissions:</label>
                        <div className="form-input">
                            <table>
                                {Object.keys(permissionGroupByCategory).map((propertyKey, keyid)=>{
                                    return (
                                        <tr key={keyid}>
                                            <td><strong className='pr-6'>{propertyKey.cap()}</strong></td>
                                            <td>{
                                                permissionGroupByCategory[propertyKey].map((permission, keyId) => {
                                                    return <span className='unit'>{permission.name}</span>;
                                                })
                                            }</td>
                                        </tr>
                                    )
                                })}
                            </table>
                            
                        </div>
                    </div>
                    
                </div>
            </Form>
        </MainLayout>
    );
}