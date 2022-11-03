import MainLayout from "@/Layouts/MainLayout"
import { DeleteButton } from "@/Shared/PageComponent/Button/Buttons";
import Component from "@/Shared/PageComponent/Form/Component"
import { Inertia } from "@inertiajs/inertia"

const Session = ({session, schedule, students, attendance}) => {
    const PRESENT = 'Hadir';
    const NOT_PRESENT = 'Tidak Hadir';
    
    const isPresent = (student) => {
        return student.attendance = attendance.find(att => att.student_id == student.id);
    }

    const setAttendance = (present,student) => {
        Inertia.post('', {
            present,
            student_id: student.id
        },{
            preserveScroll: true
        });
    }

    const deleteAttendance = (attendance) => {
        Inertia.delete(route('delete.attendance',attendance.id),{
            preserveScroll: true
        })
    }

    return <div>
        <div className="br-1">
            <div className="p-6">
                <h2 className="text-lg font-bold">
                    {schedule.class_subject}
                    <span className="float-right">
                        {schedule.class_room}
                        
                    </span>
                </h2>
                <div className="text-right">
                    <span className="float-left">
                        {schedule.teacher.name}
                    </span>
                    {dn.date(session.session_date)}<br/>{dn.time(session.session_start_time)} - {dn.time(session.session_end_time)}
                </div>
            </div>
            <table className="w-full table-padding-row">
                <tbody>
                    {
                        students.map(student => {
                            return <tr key={student.id} className='text-right hover:bg-gray-100 focus-within:bg-gray-100'>
                                <td className="text-left">{student.name}</td>
                                <td className="w-30">
                                    {isPresent(student) ? 
                                    <div>
                                        {student.attendance.present}
                                        <DeleteButton className="ml-2" onClick={e => {deleteAttendance(student.attendance)}}/>
                                    </div>: 
                                    <div>
                                        <button onClick={e => {setAttendance(PRESENT,student)}} className="btn hadir btn-indigo br-1 py-2 px-4">Hadir</button>
                                        <button onClick={e => {setAttendance(NOT_PRESENT,student)}} className="btn ml-2 mt-2 sm:mt-0 tidak-hadir br-1 py-2 px-4 opacity-80">Tidak Hadir</button>
                                    </div>
                                    }
                                </td>
                            </tr>
                        })
                    }
                </tbody>
            </table>
        </div>
    </div>
}
export default (props) => {
    return <>
        <MainLayout {...props}>
            <div className="w-full">
                <Component
                    header={
                        <h2 className="font-semibold text-xl text-gray-800 leading-tight">
                            Attendance
                            <span className="float-right">#{props.session.id}</span>
                        </h2>
                    }
                    className={'create-form no-padding'}
                >
                    <div className='grow p-6'>
                        <Session {...props}/>
                    </div>
                </Component>
            </div>
        </MainLayout>
    </>
}