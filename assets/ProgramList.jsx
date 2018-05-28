var Table = Reactstrap.Table;

class ProgramList extends React.Component {
    constructor(props) {
        super(props)
        this.handleDetails = this.handleDetails.bind(this);
    }
    handleDetails(e) {
        const index = e.currentTarget.getAttribute('data-item');
        this.props.handleChangeCountry(this.props.countries[index]);
    }
    render() {
        if (this.props.programs.length > 0) {
            const rows = this.props.programs.map((program,index) =>
                <tr key={index} data-item={index} onClick={this.handleDetails}>
                <td>{program.id}</td>
                <td>{program.fecha_publicacion}</td>
                <td>{program.lenguaje}</td>
                <td>{program.descripcion}</td></tr>);
        return (
            <Table striped>
                <thead><tr><th>ID</th><th>Fecha publicación</th><th>Lenguaje</th><th>Descripción</th></tr></thead>
                <tbody>
                {rows}
                </tbody>
            </Table>);
    }
    return (<p></p>)
    }
}