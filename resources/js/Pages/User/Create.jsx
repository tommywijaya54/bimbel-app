import React from 'react';
import MainLayout from '@/Layouts/MainLayout';
import Form from '@/Shared/DisplayPageComponent/Form/Form';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <div className='display-list overflow-x-auto bg-white rounded shadow'>
                <div className='px-2 py-6 flex'>
                    <a className='button' href='/employee/create'>Create New Employee</a>
                    <a className='button' href='/parent/create'>Create New Parent</a>
                    <a className='button' href='/student/create'>Create New Student</a>
                </div>
            </div>
            
        </MainLayout>
    );
}