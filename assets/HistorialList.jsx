var Table = Reactstrap.Table;

class HistorialList extends React.Component {
    constructor(props) {
        super(props)
        this.handleDetails = this.handleDetails.bind(this);
    }
    handleDetails(e) {
        const index = e.currentTarget.getAttribute('data-item');
        this.props.handleChangeCountry(this.props.revisiones[index]);
    }
    render() {
        if (this.props.revisiones.length > 0) {
            const rows = this.props.revisiones.map((revision,index) =>
                <tr key={index} data-item={index} onClick={this.handleDetails}>
                <td>{revision.id}</td>
                <td>{revision.descripcion}</td>
                <td>{revision.fecha}</td>
                <td>{revision.id_programador}</td></tr>);
        return (
            <Table striped>
                <thead><tr><th>ID</th><th>Descripción</th><th>Fecha</th><th>Programador</th></tr></thead>
                <tbody>
                {rows}
                </tbody>
            </Table>);
    }
    return (<p></p>)
    }
}