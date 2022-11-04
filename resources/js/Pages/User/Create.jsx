import React from 'react';
import MainLayout from '@/Layouts/MainLayout';

export default function Show(props) {
    return (
        <MainLayout
            {...props}
        >
            <div className='display-list overflow-x-auto bg-white rounded shadow'>
                <div className='p-6 flex'>
                    <a className='btn mr-4' href='/employee/create'>Create New Employee</a>
                    <a className='btn mr-4' href='/parent/create'>Create New Parent</a>
                    <a className='btn' href='/student/create'>Create New Student</a>
                </div>
            </div>
            
        </MainLayout>
    );
}