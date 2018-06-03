var Form = Reactstrap.Form;
var Button = Reactstrap.Button;
var FormGroup = Reactstrap.FormGroup;
var Label = Reactstrap.Label;
var Input = Reactstrap.Input;
var Row = Reactstrap.Row;
var Col = Reactstrap.Col;
var ButtonGroup = Reactstrap.ButtonGroup;
var Modal = Reactstrap.Modal;
var ModalHeader = Reactstrap.ModalHeader;
var ModalBody = Reactstrap.ModalBody;
var ModalFooter = Reactstrap.ModalFooter;
var DropdownMenu = Reactstrap.DropdownMenu;
var DropdownItem = Reactstrap.DropdownItem;
var Dropdown = Reactstrap.Dropdown;

class RegisterForm extends React.Component {

    constructor(props) {

        super(props)

        this.state = { id: "", is_login: "", usuario: "", password: "", nombre: "", tipo_usuario: "Usuario", dropdownOpen: false}

        this.handleInsert = this.handleInsert.bind(this);

        this.handleFields = this.handleFields.bind(this);

        this.handleRegister = this.handleRegister.bind(this);

        this.toggle = this.toggle.bind(this);
    }
    handleInsert() {
        fetch("./server/index.php/usuario/"+this.state.id,{
             method: "post",
             headers: {'Content-Type': 'application/json'},
             body: JSON.stringify({
                 method: 'put',
                 usuario: this.state.usuario,
                 password: this.state.password,
                 nombre: this.state.nombre,
                 tipo_usuario: this.state.tipo_usuario
                        })
     }).then((response) => {
            //this.props.handleChangeData();
            this.props.handleEditData(true);
        }
    );
    }
    handleFields(event) {

        const target = event.target;

        let value = target.value;

        const name = target.name;

        this.setState({ [name]: value });

    }
    handleRegister() {
        this.props.handleEditData();
    }
    toggle() {
        this.setState(prevState => ({
          dropdownOpen: !prevState.dropdownOpen
        }));
      }
    render() {

        return (<Modal isOpen={this.props.modal} toggle={this.props.handleEditData} className={this.props.className}>
          <ModalHeader toggle={this.handleEditData}>Información de país</ModalHeader>
          <ModalBody>
            <Form color="primary">
                <FormGroup><Label>Usuario:</Label>
                    <Input type="text" name="usuario"
                        value={this.state.usuario} onChange={this.handleFields}/></FormGroup>
                <FormGroup><Label>Password:</Label>
                    <Input type="text" name="password"
                        value={this.state.password} onChange={this.handleFields}/></FormGroup>
                 <FormGroup><Label>Nombre:</Label>
                    <Input type="text" name="nombre"
                        value={this.state.nombre} onChange={this.handleFields}/></FormGroup>
                <FormGroup>
                    <Label>Tipo usuario:</Label>
                    <select name="tipo_usuario" className="form-control" onChange={this.handleFields}>
                        <option selected value="Usuario">Usuario</option>
                        <option value="Programador">Programador</option>
                    </select>
                </FormGroup>
                <Input type="hidden" name="id" value={this.state.id}/>
            </Form>
          </ModalBody>
          <ModalFooter>
                <ButtonGroup><Button color="primary" onClick={this.handleInsert}>Registrar</Button>{' '}
                <Button color="secondary" onClick={this.handleRegister}>Cancelar</Button></ButtonGroup>
          </ModalFooter>
            </Modal>)

    }

}