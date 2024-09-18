import './bootstrap';
import DataTable from 'datatables.net-bs5';

new DataTable('#example', {
    ajax: '/employees',
    serverSide: true,
    columns: [
        { name: 'first_name' , title: 'Name' },
        { name: 'position' , title: 'Position' },
        { name: 'office' , title: 'Office' },
        { name: 'start_date' , title: 'Start Date' },
        { name: 'salary' , title: 'Salary' }
    ]
});