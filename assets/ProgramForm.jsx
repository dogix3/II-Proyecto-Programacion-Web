var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var FormText = Reactstrap.FormText;

class ProgramForm extends React.Component {
    constructor(props) {
        super(props)
        this.state = {id:"",num_version:"",fecha_publicacion:"",lenguaje:"",descripcion:""}
        this.handleInsert = this.handleInsert.bind(this);
        this.handleUpdate = this.handleUpdate.bind(this);
        this.handleDelete = this.handleDelete.bind(this);
        this.handleFields = this.handleFields.bind(this);
    }
    componentWillReceiveProps(nextProps) {
        this.setState({id:nextProps.program.id});
        this.setState({num_version:nextProps.program.num_version});
        this.setState({fecha_publicacion:nextProps.program.fecha_publicacion});
        this.setState({lenguaje:nextProps.program.lenguaje});
        this.setState({descripcion:nextProps.program.descripcion});
    }
    handleInsert() {
        fetch("./server/index.php/programa/"+this.state.id,{
             method: "post",
             headers: {'Content-Type': 'application/json'},
             body: JSON.stringify({
                 method: 'put',
                 name: this.state.name,
                 area: this.state.area,
                 population: this.state.population,
                 density: this.state.density
                        })
     }).then((response) => {
            this.props.handleChangeData();
        }
    );
    }
    handleUpdate() {
        fetch("/server/index.php/programa/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                name: this.state.name,
                area: this.state.area,
                population: this.state.population,
                density: this.state.density
            })
      }).then((response) => {
            this.props.handleChangeData();
        }
    );
    }
     handleDelete() {
        fetch("/server/index.php/programa/"+this.state.id,{
            method: "post",
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ method: 'delete'})
        }).then((response) => {
            this.props.handleChangeData();
        }
    );
    }
    handleFields(event) {
        const target = event.target;
        const value = target.value;
        const name = target.name;
        this.setState({[name]: value});
    }
    render() {
         return(<Form>
            <Row>
                <Col xs="6">
                    <FormGroup>
                        <Label>Numero versión:</Label>
                        <Input type="text" name="num_version" value={this.state.num_version} onChange={this.handleFields}/>
                    </FormGroup>
                </Col>
                <Col xs="6">
                    <FormGroup>
                        <Label>Fecha publicación:</Label>
                        <Input type="text" name="fecha_publicacion" value={this.state.fecha_publicacion} onChange={this.handleFields}/>
                    </FormGroup>
                </Col>
            </Row>
            <Row>
                <Col xs="6">
                <FormGroup><Label>Lenguaje:</Label>
                <Input type="text" name="lenguaje"
                    value={this.state.lenguaje} onChange={this.handleFields}/></FormGroup>
                </Col>
                <Col xs="6">
                <FormGroup><Label>Descripción:</Label>
                <Input type="text" name="descripcion"
                    value={this.state.descripcion} onChange={this.handleFields}/></FormGroup>
                </Col>
            </Row>
            <Input type="hidden" name="id" value={this.state.id}/>
            <div>
                <Button onClick={this.handleInsert}>Agregar</Button>{' '}
                <Button onClick={this.handleUpdate}>Modificar</Button>{' '}
                <Button onClick={this.handleDelete}>Eliminar</Button>{' '}
            </div></Form>)
     }
 }