import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function Show(props) {
    const groupedPermissions = props.available_permissions.reduce((group, permission) => {
        const group_name = permission.split("-")[1];
        group[group_name] = group[group_name] ?? [];
        group[group_name].push(permission);
        return group;
    }, {});

    const permissionCheck = (permission_param) => {
        return props.role_permissions.find(permission => permission === permission_param);
    }

    return (
        <MainLayout
            {...props}
        >
            <Form
                {...props.form_schema}
            >
                <div className="form-component pr-6 pb-8 w-full">
                    <label className="form-label">People that have this role:</label>
                    <div className="form-input">
                        {props.users.length == 0 && <span className='empty-value'>No one assign to this role</span>}
                        {props.users.map((user, keyid) => {
                            return <span key={keyid} className="unit">{user.name}</span>
                        })}
                    </div>
                </div>
                        
                <div className='pt-8'>
                    <div className="form-component pr-6 pb-8 w-full">
                        <label className="form-label">Permissions that this role have:</label>
                        <div className="form-input">
                            <table>
                                <tbody>
                                {Object.keys(groupedPermissions).map((propertyKey, keyid)=>{
                                    return (
                                        <tr key={keyid} className='hover:bg-gray-100 focus-within:bg-gray-100'>
                                            <td><span className='px-4 py-6'>{propertyKey.cap()}</span></td>
                                            <td>{
                                                groupedPermissions[propertyKey].map((permission, keyId) => {
                                                    return <span key={keyId} className={'unit small check-'+(permissionCheck(permission)?'have':'not-have')}>{permission}</span>;
                                                })
                                            }</td>
                                        </tr>
                                    )
                                })}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
            </Form>
        </MainLayout>
    );
}
